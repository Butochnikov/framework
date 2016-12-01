<?php
namespace SleepingOwl\Api\Providers;

use Illuminate\Support\ServiceProvider;
use League\Fractal\Serializer\JsonApiSerializer;
use SleepingOwl\Api\Exceptions\Handler as ExceptionHandler;
use SleepingOwl\Api\Manager;

class ApiServiceProvider extends ServiceProvider
{

    public function register()
    {
        $this->app->singleton('sleepingowl.api', function () {
            $manager = new Manager();
            $manager->setSerializer(new JsonApiSerializer());

            return $manager;
        });

        $this->registerExceptionHandler();
    }

    /**
     * Register the exception handler.
     *
     * @return void
     */
    protected function registerExceptionHandler()
    {
        $this->app->singleton('sleepingowl.api.exception', function ($app) {
            return new ExceptionHandler(
                $app['Illuminate\Contracts\Debug\ExceptionHandler'],
                (bool) $app['config']['app.debug']
            );
        });
    }
}