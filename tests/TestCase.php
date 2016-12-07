<?php

use Illuminate\Config\Repository as ConfigRepository;
use Illuminate\Foundation\Application;
use Mockery as m;
use SleepingOwl\Framework\SleepingOwl;
use SleepingOwl\Framework\Themes\ThemesManager;

class TestCase extends PHPUnit_Framework_TestCase
{

    public function tearDown()
    {
        m::close();
    }

    /**
     * @return \SleepingOwl\Framework\Contracts\Routing\Router
     */
    public function getRouter()
    {
        return m::mock(\SleepingOwl\Framework\Contracts\Routing\Router::class);
    }

    /**
     * @param string $url
     *
     * @return \Illuminate\Http\Request
     */
    public function getRequest($url = 'http://www.foo.com/hello/world')
    {
        return Illuminate\Http\Request::create($url);
    }

    /**
     * @param array $config
     *
     * @return Application
     */
    protected function getApplication(array $config = [])
    {
        $app = m::mock(new Application());
        $app->shouldReceive('bootstrapPath')->andReturn(TEST_STUBS);

        $app['config'] = new ConfigRepository(array_merge_recursive([
            'sleepingowl' => [
                'url_prefix' => 'text_backend'
            ]
        ], $config));

        $app['view'] = $view = m::mock(\Illuminate\Contracts\View\View::class);
        $view->shouldReceive('make')->andReturnUsing(function () {
            $view = m::mock(Illuminate\View\View::class);
            $view->shouldReceive('render')->andReturn('string');

            return $view;
        });

        $app['request'] = $this->getRequest();
        $app['SleepingOwl\Framework\Contracts\Routing\Router'] = $router = $this->getRouter();

        $app['request']->headers->set('referer', 'http://www.site.com/hello/world');

        $router->shouldReceive('getUrlPrefix')->andReturn('test_prefix');

        $url = new \SleepingOwl\Framework\Routing\UrlGenerator(
            $routes = new Illuminate\Routing\RouteCollection(),
            $router,
            $app['request'],
            $this->getThemeManager($app)
        );

        $app->instance(\SleepingOwl\Framework\Routing\UrlGenerator::class, $url);

        return $app;
    }

    /**
     * @param Closure $closure
     * @param string|null $path
     * @param array $config
     *
     * @return SleepingOwl
     */
    protected function getFramework(Closure $closure = null, $path = null, array $config = [])
    {
        $app = $this->getApplication($config);

        if (is_callable($closure)) {
            $closure($app);
        }

        return new SleepingOwl($app, $path);
    }

    /**
     * @param Application|null $app
     *
     * @param Illuminate\Contracts\Events\Dispatcher $events
     * @return ThemesManager
     */
    protected function getThemeManager(Application $app = null, Illuminate\Contracts\Events\Dispatcher $events = null)
    {
        if (! $events) {
            $events = m::mock(\Illuminate\Contracts\Events\Dispatcher::class);
            $events->shouldReceive('fire');
        }

        return new ThemesManager(
            $app ?: $this->getApplication(),
            $events
        );
    }
}