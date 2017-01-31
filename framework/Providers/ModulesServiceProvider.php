<?php
namespace SleepingOwl\Framework\Providers;

use Nwidart\Modules\LaravelModulesServiceProvider;
use Nwidart\Modules\Providers\ConsoleServiceProvider;
use Nwidart\Modules\Providers\ContractsServiceProvider;
use SleepingOwl\Framework\Repositories\ModulesRepository;

class ModulesServiceProvider extends LaravelModulesServiceProvider
{
    /**
     * Register the service provider.
     */
    protected function registerServices()
    {
        $this->app->singleton('modules', function ($app) {
            $path = $app['config']->get('modules.paths.modules');

            return new ModulesRepository($app, $app['files'], $path);
        });
    }


    /**
     * Register providers.
     */
    protected function registerProviders()
    {
        if ($this->app->runningInConsole()) {
            $this->app->register(ConsoleServiceProvider::class);
        }

        $this->app->register(ContractsServiceProvider::class);
    }


    /**
     * Register package's namespaces.
     */
    protected function registerNamespaces()
    {
        $configPath = __DIR__ . '/../../config/modules.php';
        $this->mergeConfigFrom($configPath, 'modules');

        $this->publishes([
            $configPath => config_path('modules.php'),
        ], 'sleepingowl-config');
    }
}