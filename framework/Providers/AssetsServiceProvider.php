<?php
namespace SleepingOwl\Framework\Providers;

use Illuminate\Support\ServiceProvider;
use KodiCMS\Assets\PackageManager;
use SleepingOwl\Framework\Template\Assets;
use SleepingOwl\Framework\Template\Meta;

class AssetsServiceProvider extends ServiceProvider
{

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;

    public function boot()
    {
        $this->app->singleton('assets.packages', function () {
            return new PackageManager();
        });

        $this->app->singleton('sleepingowl.meta', function ($app) {
            $this->app->instance('sleepingowl.assets', $assets =  new Assets(
                $app['assets.packages']
            ));

            return new Meta($assets);
        });
    }

    /**
     * @return array
     */
    public function provides()
    {
        return [
            'assets.packages',
            'sleepingowl.meta',
            'sleepingowl.assets',
            'KodiCMS\Assets\PackageManager',
            'SleepingOwl\Framework\Contracts\Template\Meta',
            'SleepingOwl\Framework\Template\Meta',
            'SleepingOwl\Framework\Contracts\Template\Assets',
            'SleepingOwl\Framework\Template\Assets'
        ];
    }
}