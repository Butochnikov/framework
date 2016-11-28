<?php
namespace SleepingOwl\Framework\Providers;

use Illuminate\Support\ServiceProvider;
use SleepingOwl\Framework\Themes\ThemesManager;

class ThemeServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;

    public function register()
    {
        $this->app->singleton('sleepingowl.themes', function () {
            return new ThemesManager($this->app);
        });
    }

    public function boot()
    {
        $this->app->singleton('sleepingowl.theme', function ($app) {
            return $app['sleepingowl.themes']->theme();
        });
    }

    /**
     * @return array
     */
    public function provides()
    {
        return [
            'sleepingowl.theme',
            'SleepingOwl\Framework\Contracts\Themes\Theme',
            'SleepingOwl\Framework\Themes\Theme'
        ];
    }
}