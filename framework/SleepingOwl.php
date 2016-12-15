<?php
namespace SleepingOwl\Framework;

use Illuminate\Config\Repository as ConfigRepository;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Foundation\ProviderRepository;
use SleepingOwl\Framework\Contracts\SleepingOwl as SleepingOwlContract;

class SleepingOwl implements SleepingOwlContract
{
    use Configuration\ManagesAppDetails,
        Configuration\ManagesContext,
        Configuration\ManagesAuthOptions,
        Configuration\ProvidesScriptVariables;

    /**
     * Версия фреймворка
     */
    const VERSION = '0.0.1 alpha';

    /**
     * @var \Illuminate\Foundation\Application
     */
    protected $app;

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
        $this->registerCoreRepositories();

        if ($basePath) {
            $this->setBasePath($basePath);
        }
    }

    /**
     * Получение версии фреймворка
     *
     * @return string
     */
    public function version(): string
    {
        return static::VERSION;
    }

    /**
     * Получение название фреймворка
     *
     * @return string
     */
    public function name(): string
    {
        return 'SleepingOwl framework';
    }

    /**
     * Получение названия фреймворка с указанием версии
     *
     * @return string
     */
    public function longName(): string
    {
        return $this->name().' v.'.$this->version();
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
            Providers\NavigationServiceProvider::class,
            Providers\AssetsServiceProvider::class,
            Providers\ThemeServiceProvider::class,
            Providers\AuthServiceProvider::class,
            Providers\RouteServiceProvider::class,
            Providers\EventServiceProvider::class,
            Providers\BreadcrumbsServiceProvider::class,
            \SleepingOwl\Api\Providers\ApiServiceProvider::class,
            Providers\ModulesServiceProvider::class,
        ];

        $manifestPath = $this->app->bootstrapPath().'/cache/sleepingowl-services.php';

        (new ProviderRepository($this->app, new Filesystem(), $manifestPath))
            ->load($providers);
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
            'sleepingowl.assets' => ['SleepingOwl\Framework\Template\Assets', 'SleepingOwl\Framework\Contracts\Template\Assets'],
            'sleepingowl.router' => ['SleepingOwl\Framework\Routing\Router', 'SleepingOwl\Framework\Contracts\Routing\Router'],
            'sleepingowl.url' => ['SleepingOwl\Framework\Routing\UrlGenerator', 'SleepingOwl\Framework\Contracts\Routing\UrlGenerator'],
            'sleepingowl.api' => ['SleepingOwl\Api\Contracts\Manager', 'SleepingOwl\Api\Manager'],
            'sleepingowl.api.exception' => ['SleepingOwl\Api\Exceptions\Handler', 'SleepingOwl\Api\Contracts\Exceptions\Handler'],
            'sleepingowl.breadcrumbs' => ['SleepingOwl\Framework\Contracts\Template\Breadcrumbs']
        ];

        foreach ($aliases as $key => $aliases) {
            foreach ($aliases as $alias) {
                $this->app->alias($key, $alias);
            }
        }
    }

    protected function registerCoreRepositories()
    {
        $repositories = [
            'Contracts\Repositories\UserMetaRepository' => 'Repositories\UserMetaRepository'
        ];

        foreach ($repositories as $contract => $repository) {
            $this->app->singleton(
                'SleepingOwl\Framework\\'.$contract,
                'SleepingOwl\Framework\\'.$repository
            );
        }
    }
}