<?php
namespace SleepingOwl\Framework\Routing;

use Closure;
use Illuminate\Contracts\Routing\Registrar as RegistrarContract;
use SleepingOwl\Framework\Contracts\Routing\Router as RouterContract;

class Router implements RouterContract
{
    /**
     * @var RegistrarContract
     */
    private $router;

    /**
     * @var string
     */
    private $urlPrefix;

    /**
     * Router constructor.
     *
     * @param RegistrarContract $router
     * @param $urlPrefix
     */
    public function __construct(RegistrarContract $router, string $urlPrefix)
    {
        $this->router = $router;

        $this->urlPrefix = $urlPrefix;
    }

    /**
     * Register the backend authentication routes
     *
     * @return void
     */
    public function auth()
    {
        // Authentication Routes...
        $this->router->get('login', 'Auth\LoginController@showLoginForm')->name('login');
        $this->router->post('login', 'Auth\LoginController@login');
        $this->router->post('logout', 'Auth\LoginController@logout')->name('logout');

        // Password Reset Routes...
        $this->router->get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm');
        $this->router->post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail');
        $this->router->get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm');
        $this->router->post('password/reset', 'Auth\ResetPasswordController@reset');
    }

    /**
     * Получение префикса для админ интерфеса
     *
     * @return string
     */
    public function getUrlPrefix(): string
    {
        return $this->urlPrefix;
    }

    /**
     * Создание группы роутов с правами доступа к админ интерфейсу
     *
     * @param array $attributes
     * @param Closure $callback
     *
     * @return void
     */
    public function backendGroup(array $attributes, Closure $callback)
    {
        $this->router->group(
            $this->mergeGroupAttributes($attributes),
            $callback
        );
    }

    /**
     * Dynamically call the default router instance.
     *
     * @param  string $method
     * @param  array $parameters
     *
     * @return mixed
     */
    public function __call($method, $parameters)
    {
        return $this->router->$method(...$parameters);
    }

    /**
     * @param array $attributes
     *
     * @return array
     */
    protected function mergeGroupAttributes(array $attributes)
    {
        $attributes = $this->mergeAttributeMiddleware($attributes);
        $attributes = $this->mergeAttributePrefix($attributes);

        return $attributes;
    }

    /**
     * @param array $attributes
     *
     * @return array
     */
    protected function mergeAttributeMiddleware(array $attributes)
    {
        if (isset($attributes['middleware'])) {
            $attributes['middleware'] = (array) $attributes['middleware'];
            if (! in_array('backend', $attributes['middleware'])) {
                $attributes['middleware'][] = 'backend';
            }
        } else {
            $attributes['middleware'] = 'backend';
        }

        return $attributes;
    }

    /**
     * @param array $attributes
     *
     * @return array
     */
    protected function mergeAttributePrefix(array $attributes)
    {
        if (isset($attributes['prefix'])) {
            $attributes['prefix'] = $this->urlPrefix.'/'.ltrim($attributes['prefix'], '/');
        } else {
            $attributes['prefix'] = $this->urlPrefix;
        }

        return $attributes;
    }
}