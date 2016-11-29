<?php
namespace SleepingOwl\Framework\Routing;

use Illuminate\Http\Request;
use Illuminate\Routing\RouteCollection;
use Illuminate\Routing\UrlGenerator as BaseUrlGenerator;
use SleepingOwl\Framework\Contracts\Routing\Router as RouterContract;

class UrlGenerator extends BaseUrlGenerator
{
    /**
     * @var RouterContract
     */
    protected $router;

    /**
     * @param RouteCollection $routes
     * @param RouterContract $router
     * @param Request $request
     */
    public function __construct(RouteCollection $routes, RouterContract $router, Request $request)
    {
        parent::__construct($routes, $request);
        $this->router = $router;
    }

    /**
     * @return string
     */
    public function prefix()
    {
        return $this->router->getUrlPrefix();
    }

    /**
     * {@inheritdoc}
     */
    public function asset($path, $secure = null)
    {
        return parent::asset(
            theme()->assetPath($path),
            $secure
        );
    }

    /**
     * {@inheritdoc}
     */
    public function assetFrom($root, $path, $secure = null)
    {
        return parent::assetFrom(
            $root,
            theme()->assetPath($path),
            $secure
        );
    }

    /**
     * {@inheritdoc}
     */
    protected function trimUrl($root, $path, $tail = '')
    {
        return trim($root.'/'.$this->prefix().'/'.trim($path.'/'.$tail, '/'), '/');
    }
}
