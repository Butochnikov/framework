<?php
namespace SleepingOwl\Framework\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'Illuminate\Console\Events\ArtisanStarting' => [
            'SleepingOwl\Framework\Listeners\Console\ChangeApplicationVersion',
        ],
        'SleepingOwl\Framework\Events\ThemeLoaded' => [

        ]
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();
        //
    }
}
