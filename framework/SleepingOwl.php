<?php
namespace SleepingOwl\Framework;

use SleepingOwl\Framework\Contracts\SleepingOwl as SleepingOwlContract;
use SleepingOwl\Framework\Providers\AssetsServiceProvider;
use SleepingOwl\Framework\Providers\NavigationServiceProvider;
use SleepingOwl\Framework\Providers\RouteServiceProvider;
use SleepingOwl\Framework\Providers\ThemeServiceProvider;

class SleepingOwl implements SleepingOwlContract
{
    /**
     * The SleepingOwl version.
     */
    const VERSION = '0.0.1 alpha';

    /**
     * @var \Illuminate\Foundation\Application
     */
    private $application;

    /**
     * The base path for the SleepingOwl installation.
     *
     * @var string
     */
    protected $basePath;

    /**
     * Create a new SleepingOwl framework instance.
     *
     * @param \Illuminate\Contracts\Foundation\Application $application
     * @param string|null $basePath
     */
    public function __construct(\Illuminate\Contracts\Foundation\Application $application, string $basePath = null)
    {
        $this->application = $application;

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
     * Register all of the base service providers.
     *
     * @return void
     */
    protected function registerBaseServiceProviders()
    {
        $this->application->register(new RouteServiceProvider($this->application));
        $this->application->register(new NavigationServiceProvider($this->application));
        $this->application->register(new AssetsServiceProvider($this->application));
        $this->application->register(new ThemeServiceProvider($this->application));
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
        $this->application->instance('sleepingowl.path.base', $this->basePath());
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
            'sleepingowl.meta' => ['SleepingOwl\Framework\Contracts\Template\Meta', 'SleepingOwl\Framework\Template\Meta']
        ];

        foreach ($aliases as $key => $aliases) {
            foreach ($aliases as $alias) {
                $this->application->alias($key, $alias);
            }
        }
    }
}