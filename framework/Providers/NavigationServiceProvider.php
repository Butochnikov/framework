<?php
namespace SleepingOwl\Framework\Providers;

use Illuminate\Support\ServiceProvider;
use SleepingOwl\Framework\Template\Navigation;

class NavigationServiceProvider extends ServiceProvider
{

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;

    public function boot()
    {
        $this->app->singleton('sleepingowl.navigation', function () {
            return new Navigation();
        });
    }

    /**
     * @return array
     */
    public function provides()
    {
        return [
            'sleepingowl.navigation',
            'SleepingOwl\Framework\Contracts\Template\Navigation',
            'SleepingOwl\Framework\Template\Navigation'
        ];
    }
}