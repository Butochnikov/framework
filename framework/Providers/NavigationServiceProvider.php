<?php
namespace SleepingOwl\Framework\Providers;

use Illuminate\Support\ServiceProvider;
use KodiComponents\Navigation\Contracts\BadgeInterface;
use KodiComponents\Navigation\Contracts\PageInterface;
use SleepingOwl\Framework\Contracts\SleepingOwl;
use SleepingOwl\Framework\Template\Navigation\Badge;
use SleepingOwl\Framework\Template\Navigation\Page;
use SleepingOwl\Framework\Template\Navigation;

class NavigationServiceProvider extends ServiceProvider
{

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;

    public function boot(SleepingOwl $framework)
    {
        $this->app->bind(PageInterface::class, Page::class);
        $this->app->bind(BadgeInterface::class, Badge::class);

        $this->app->singleton('sleepingowl.navigation', function () {
            return new Navigation();
        });

        $this->app->booted(function() use($framework) {
            if (file_exists($file = $framework->basePath().'/routes/navigation.php')) {
                $navigation = require $file;
            } else {
                $navigation = [];
            }

            $this->app[\SleepingOwl\Framework\Contracts\Template\Navigation::class]->setFromArray($navigation);
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