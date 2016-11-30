<?php
namespace SleepingOwl\Framework\Http\Middleware;

use Closure;
use Illuminate\Contracts\View\Factory as ViewFactory;
use Illuminate\Http\Request;

class ShareRouteActionToViews
{
    /**
     * @var ViewFactory
     */
    private $view;

    /**
     * Controller constructor.
     *
     * @param ViewFactory $factory
     */
    public function __construct(ViewFactory $factory)
    {
        $this->view = $factory;
    }

    /**
     * @param Request $request
     * @param Closure $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $this->view->share('routeAction', $request->route()->getActionName());

        return $next($request);
    }
}