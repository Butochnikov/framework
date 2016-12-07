<?php
namespace SleepingOwl\Framework\Providers;

use Illuminate\Support\ServiceProvider;
use SleepingOwl\Framework\Contracts\SleepingOwl;

class BreadcrumbsServiceProvider extends ServiceProvider
{

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('sleepingowl.breadcrumbs', function () {
            return $this->app->make(\SleepingOwl\Framework\Template\Breadcrumbs::class);
        });
    }

    /**
     * Bootstrap the application events.
     *
     * @param SleepingOwl $framework
     */
    public function boot(SleepingOwl $framework)
    {
        $this->app->booted(function () use($framework) {
            $breadcrumbs = $this->app['sleepingowl.breadcrumbs'];
            $navigation = $this->app['sleepingowl.navigation'];

            // Load the app breadcrumbs if they're in routes/breadcrumbs.php (Laravel 5.3)
            if (file_exists($file = $framework->basePath().'/routes/breadcrumbs.php')) {
                require $file;
            }

            $navigation->buildBreadcrumbs($breadcrumbs);
        });
    }

    /**
     * @return array
     */
    public function provides()
    {
        return [
            'sleepingowl.breadcrumbs',
            'SleepingOwl\Framework\Contracts\Template\Breadcrumbs'
        ];
    }
}
