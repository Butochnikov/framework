<?php

namespace SleepingOwl\Framework\Providers;

use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;

class SleepingOwlServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->registerConsoleCommands();
        $this->initDefaultPackageConfig();
    }

    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        $this->defineRoutes($this->app['router']);
        $this->defineResources();
    }

    /**
     * Define the SleepingOwl routes.
     *
     * @param Router $router
     * @return void
     */
    protected function defineRoutes(Router $router)
    {
        $this->defineRoutesMiddleware($router);
        $this->defineRouteBindings($router);

        // If the routes have not been cached, we will include them in a route group
        // so that all of the routes will be conveniently registered to the given
        // controller namespace. After that we will load the Spark routes file.
        if (! $this->app->routesAreCached()) {
            $router->group([
                'namespace' => 'SleepingOwl\Framework\Http\Controllers'],
                function ($router) {
                    require SLEEPINGOWL_PATH.'/Http/routes.php';
                }
            );
        }
    }


    /**
     * Define the SleepingOwl routes middleware
     *
     * @param Router $router
     * @return void
     */
    protected function defineRoutesMiddleware(Router $router)
    {
        $router->middleware('backend.auth', \SleepingOwl\Framework\Http\Middleware\Authenticate::class);

        $router->middlewareGroup('backend', [
            'web', 'backend.auth'
        ]);
    }

    /**
     * Define the SleepingOwl route model bindings.
     *
     * @param Router $router
     * @return void
     */
    protected function defineRouteBindings(Router $router)
    {

    }

    /**
     * Define the SleepingOwl Resources.
     *
     * @return void
     */
    protected function defineResources()
    {
        $this->publishes([
            SLEEPINGOWL_PATH.'/config/sleepingowl.php' => config_path('sleepingowl.php'),
        ], 'config');

        $this->publishes([
            SLEEPINGOWL_PATH.'/resources/lang' => resource_path('lang/vendor/sleepingowl'),
            SLEEPINGOWL_PATH.'/resources/views' => resource_path('views/vendor/sleepingowl'),
        ], 'resources');

        $this->publishes([
            SLEEPINGOWL_PATH.'/public' => public_path('vendor/sleepingowl'),
        ], 'public');

        $this->loadMigrationsFrom(SLEEPINGOWL_PATH.'/database/migrations');
        $this->loadTranslationsFrom(SLEEPINGOWL_PATH.'/resources/lang', 'sleepingowl');
        $this->loadViewsFrom(SLEEPINGOWL_PATH.'/resources/views', 'sleepingowl');
    }

    protected function initDefaultPackageConfig()
    {
        $this->mergeConfigFrom(
            SLEEPINGOWL_PATH.'/config/sleepingowl.php', 'sleepingowl'
        );
    }

    protected function registerConsoleCommands()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                \SleepingOwl\Framework\Console\Commands\InstallCommand::class,
            ]);
        }
    }
}