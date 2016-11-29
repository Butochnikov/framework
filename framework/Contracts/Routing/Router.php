<?php
namespace SleepingOwl\Framework\Contracts\Routing;

use Closure;

interface Router
{
    /**
     * Создание группы роутов с правами доступа к админ интерфейсу
     *
     * @param array $attributes
     * @param Closure $callback
     *
     * @return void
     */
    public function backendGroup(array $attributes, Closure $callback);

    /**
     * Получение префикса для админ интерфеса
     *
     * @return string
     */
    public function getUrlPrefix(): string;
}