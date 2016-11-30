<?php
namespace SleepingOwl\Framework;

use Illuminate\Config\Repository as ConfigRepository;
use Illuminate\Contracts\Foundation\Application;
use SleepingOwl\Framework\Contracts\SleepingOwl as SleepingOwlContract;

class SleepingOwl implements SleepingOwlContract
{
    use Configuration\ManagesContext,
        Configuration\ManagesAuthOptions;

    /**
     * The SleepingOwl version.
     */
    const VERSION = '0.0.1 alpha';

    /**
     * @var \Illuminate\Foundation\Application
     */
    private $app;

    /**
     * The base path for the SleepingOwl installation.
     *
     * @var string
     */
    protected $basePath;

    /**
     * @var ConfigRepository
     */
    protected $config;

    /**
     * Create a new SleepingOwl framework instance.
     *
     * @param Application $application
     * @param string|null $basePath
     */
    public function __construct(Application $application, string $basePath = null)
    {
        $this->app = $application;
        $this->config = new ConfigRepository(
            $this->app['config']->get('sleepingowl', [])
        );

        $this->registerBaseServiceProviders();
        $this->registerCoreContainerAliases();

        if ($basePath) {
            $this->setBasePath($basePath);
        }
    }

    /**
     * Get the version number of the framework.
     *
     * @return string
     */
    public function version(): string
    {
        return static::VERSION;
    }

    /**
     * Получить название фреймворка
     *
     * @return string
     */
    public function name(): string
    {
        return 'SleepingOwl framework v.'.$this->version();
    }

    /**
     * Получение настроек
     *
     * @return ConfigRepository
     */
    public function config(): ConfigRepository
    {
        return $this->config;
    }

    /**
     * Register all of the base service providers.
     *
     * @return void
     */
    protected function registerBaseServiceProviders()
    {
        $providers = [
            \SleepingOwl\Framework\Providers\NavigationServiceProvider::class,
            \SleepingOwl\Framework\Providers\AssetsServiceProvider::class,
            \SleepingOwl\Framework\Providers\ThemeServiceProvider::class,
            \SleepingOwl\Framework\Providers\AuthServiceProvider::class,
            \SleepingOwl\Framework\Providers\RouteServiceProvider::class,
        ];

        foreach ($providers as $provider) {
            $this->app->register(new $provider($this->app));
        }
    }

    /**
     * Get the base path of the SleepingOwl installation.
     *
     * @return string
     */
    public function basePath(): string
    {
        return $this->basePath;
    }

    /**
     * Set the base path for the SleepingOwl framework.
     *
     * @param  string  $basePath
     * @return $this
     */
    public function setBasePath(string $basePath)
    {
        $this->basePath = rtrim($basePath, '\/');

        $this->bindPathsInContainer();

        return $this;
    }

    /**
     * Bind all of the application paths in the container.
     *
     * @return void
     */
    protected function bindPathsInContainer()
    {
        $this->app->instance('sleepingowl.path.base', $this->basePath());
    }

    /**
     * Register the core class aliases in the container.
     *
     * @return void
     */
    protected function registerCoreContainerAliases()
    {
        $aliases = [
            'sleepingowl' => ['SleepingOwl\Framework\Contracts\SleepingOwl', 'SleepingOwl\Framework\SleepingOwl'],
            'sleepingowl.themes' => ['SleepingOwl\Framework\Contracts\Themes\Factory', 'SleepingOwl\Framework\Themes\ThemesManager'],
            'sleepingowl.theme' => ['SleepingOwl\Framework\Contracts\Themes\Theme', 'SleepingOwl\Framework\Themes\Theme'],
            'sleepingowl.navigation' => ['SleepingOwl\Framework\Contracts\Template\Navigation', 'SleepingOwl\Framework\Template\Navigation'],
            'sleepingowl.meta' => ['SleepingOwl\Framework\Contracts\Template\Meta', 'SleepingOwl\Framework\Template\Meta'],
            'sleepingowl.router' => ['SleepingOwl\Framework\Routing\Router', 'SleepingOwl\Framework\Contracts\Routing\Router'],
            'sleepingowl.url' => ['SleepingOwl\Framework\Routing\UrlGenerator', 'SleepingOwl\Framework\Contracts\Routing\UrlGenerator']
        ];

        foreach ($aliases as $key => $aliases) {
            foreach ($aliases as $alias) {
                $this->app->alias($key, $alias);
            }
        }
    }
}