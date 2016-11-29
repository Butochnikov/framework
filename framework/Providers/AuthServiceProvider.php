<?php
namespace SleepingOwl\Framework\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use SleepingOwl\Framework\Contracts\SleepingOwl;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [

    ];


    public function register()
    {
    }

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $framework = $this->app[SleepingOwl::class];

        $this->app['config']->set('auth.guards.backend', [
            'driver' => 'session',
            'provider' => 'backend_users',
        ]);

        $this->app['config']->set('auth.providers.backend_users', $framework->config()->get('guard_provider', [
            'driver' => 'eloquent',
            'model' => \SleepingOwl\Framework\Entities\User::class
        ]));

        $this->registerPolicies();

        //
    }
}
