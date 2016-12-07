<?php
namespace SleepingOwl\Framework\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use SleepingOwl\Framework\SleepingOwl;

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
        $this->app['config']->set('auth.guards.'.SleepingOwl::guard(), SleepingOwl::guardConfig());

        $this->app['config']->set('auth.providers.backend_users', SleepingOwl::guardProvider());

        $this->registerPolicies();

        //
    }
}
