<?php

namespace SleepingOwl\Framework\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use SleepingOwl\Framework\Contracts\Routing\Router as RouterContract;
use SleepingOwl\Framework\Contracts\SleepingOwl;

class Context
{
    /**
     * @var SleepingOwl
     */
    protected $framework;

    /**
     * @var SleepingOwl
     */
    protected $urlPrefix;

    /**
     * @param SleepingOwl $framework
     * @param RouterContract $router
     */
    public function __construct(SleepingOwl $framework, RouterContract $router)
    {
        $this->framework = $framework;
        $this->urlPrefix = $router->getUrlPrefix();
    }

    /**
     * @param $request
     * @param Closure $next
     * @param string|null $context
     *
     * @return mixed
     */
    public function handle($request, Closure $next, string $context = null)
    {
        if (is_null($context)) {
            $context = $this->getContext($request);
        }

        $contexts = explode('|', $context);
        foreach ($contexts as $context) {
            $this->framework->setContext($context);
        }

        return $next($request);
    }

    /**
     * @param Request $request
     *
     * @return mixed
     */
    protected function getContext(Request $request)
    {
        return ($request->is($this->urlPrefix) or $request->is($this->urlPrefix.'/*'))
            ? SleepingOwl::CTX_BACKEND
            : SleepingOwl::CTX_FRONTEND;
    }
}