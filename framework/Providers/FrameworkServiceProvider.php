<?php
namespace SleepingOwl\Framework\Providers;

use Illuminate\Support\ServiceProvider;
use SleepingOwl\Framework\SleepingOwl;

class FrameworkServiceProvider extends ServiceProvider
{

    /**
     * @var SleepingOwl
     */
    protected $framework;

    public function register()
    {
        $this->app->instance('sleepingowl', $this->framework = new SleepingOwl($this->app, SLEEPINGOWL_PATH));

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
        $this->defineResources();
    }

    /**
     * Define the SleepingOwl Resources.
     *
     * @return void
     */
    protected function defineResources()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                SLEEPINGOWL_PATH.'/config/sleepingowl.php' => config_path('sleepingowl.php'),
            ], 'sleepingowl-config');

            $this->publishes([
                SLEEPINGOWL_PATH.'/resources/lang' => resource_path('lang/vendor/sleepingowl'),
                SLEEPINGOWL_PATH.'/resources/views' => resource_path('views/vendor/sleepingowl'),
            ], 'sleepingowl-resources');

            $this->publishes([
                SLEEPINGOWL_PATH.'/public' => public_path('vendor/sleepingowl'),
            ], 'sleepingowl-asset');
        }

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