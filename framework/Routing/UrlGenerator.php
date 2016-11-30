<?php
namespace SleepingOwl\Framework\Routing;

use Illuminate\Http\Request;
use Illuminate\Routing\RouteCollection;
use Illuminate\Routing\UrlGenerator as BaseUrlGenerator;
use SleepingOwl\Framework\Contracts\Routing\Router as RouterContract;
use SleepingOwl\Framework\Contracts\Routing\UrlGenerator as UrlGeneratorContract;
use SleepingOwl\Framework\Contracts\Themes\Factory as ThemeFactory;

class UrlGenerator extends BaseUrlGenerator implements UrlGeneratorContract
{
    /**
     * @var RouterContract
     */
    protected $router;

    /**
     * @var ThemeFactory
     */
    private $themeFactory;

    /**
     * @param RouteCollection $routes
     * @param RouterContract $router
     * @param Request $request
     * @param ThemeFactory $factory
     */
    public function __construct(RouteCollection $routes, RouterContract $router, Request $request, ThemeFactory $factory)
    {
        parent::__construct($routes, $request);
        $this->router = $router;
        $this->themeFactory = $factory;
    }

    /**
     * Получение префикса админ панели
     *
     * @return string
     */
    public function prefix(): string
    {
        return $this->router->getUrlPrefix();
    }

    /**
     * {@inheritdoc}
     */
    public function asset($path, $secure = null)
    {
        if ($this->isValidUrl($path)) {
            return $path;
        }

        return parent::asset(
            $this->themeFactory->assetPath($path),
            $secure
        );
    }

    /**
     * Get the current URL for the request.
     *
     * @return string
     */
    public function current()
    {
        return parent::to($this->request->getPathInfo());
    }

    /**
     * {@inheritdoc}
     */
    public function assetFrom($root, $path, $secure = null)
    {
        return parent::assetFrom(
            $root,
            $this->themeFactory->assetPath($path),
            $secure
        );
    }

    /**
     * Generate an absolute URL to the given path.
     *
     * @param  string  $path
     * @param  mixed  $extra
     * @param  bool|null  $secure
     * @return string
     */
    public function to($path, $extra = [], $secure = null)
    {
        if ($this->isValidUrl($path)) {
            return $path;
        }

        $path = $this->prependUrlPrefix($path);

        return parent::to($path, $extra, $secure);
    }

    /**
     * @param string $path
     *
     * @return string
     */
    protected function prependUrlPrefix(string $path): string
    {
        return $this->prefix().'/'.ltrim($path, '/');
    }
}
