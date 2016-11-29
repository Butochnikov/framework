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
        if (isset($attributes['middleware'])) {
            $attributes['middleware'] = (array) $attributes['middleware'];
            if (! in_array('backend', $attributes['middleware'])) {
                $attributes['middleware'][] = 'backend';
            }
        } else {
            $attributes['middleware'] = 'backend';
        }

        $attributes['prefix'] = $this->urlPrefix;

        $this->router->group($attributes, $callback);
    }

    /**
     * Dynamically call the default router instance.
     *
     * @param  string  $method
     * @param  array   $parameters
     * @return mixed
     */
    public function __call($method, $parameters)
    {
        return $this->router->$method(...$parameters);
    }
}