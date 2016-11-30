<?php
namespace SleepingOwl\Framework\Http;

use App\Http\Kernel as AppKernel;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Routing\Router;
use SleepingOwl\Framework\Contracts\Routing\Router as RouterContract;
use SleepingOwl\Framework\Contracts\SleepingOwl;

class Kernel extends AppKernel
{
    /**
     * @var SleepingOwl
     */
    protected $framework;

    /**
     * Create a new HTTP kernel instance.
     *
     * @param  \Illuminate\Contracts\Foundation\Application $app
     * @param  \Illuminate\Routing\Router $router
     */
    public function __construct(Application $app, Router $router)
    {
        parent::__construct($app, $router);

        $router->middleware('context', \SleepingOwl\Framework\Http\Middleware\Context::class);
        $router->middleware('backend.auth', \SleepingOwl\Framework\Http\Middleware\Authenticate::class);

        $router->middlewareGroup('backend', [
            'web',
            \SleepingOwl\Framework\Http\Middleware\ShareRouteActionToViews::class,
            'context:backend'
        ]);
    }

    /**
     * Get the route dispatcher callback.
     *
     * @return \Closure
     */
    protected function dispatchToRouter()
    {
        return function ($request) {
            $this->app->instance('request', $request);

            $this->app[SleepingOwl::class]->setContext(
                $this->detectContext($request)
            );

            return $this->router->dispatch($request);
        };
    }

    /**
     * Определение контекста по Request запросу
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return string
     */
    protected function detectContext(\Illuminate\Http\Request $request)
    {
        $urlPrefix = $this->app[RouterContract::class]->getUrlPrefix();

        return ($request->is($urlPrefix) or $request->is($urlPrefix.'/*'))
            ? SleepingOwl::CTX_BACKEND
            : SleepingOwl::CTX_FRONTEND;
    }
}