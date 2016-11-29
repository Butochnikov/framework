<?php

if (! defined('SLEEPINGOWL_PATH')) {
    define('SLEEPINGOWL_PATH', realpath(__DIR__));
}

if (! function_exists('framework')) {

    /**
     * Получение объекта фреймфорка
     *
     * @return SleepingOwl\Framework\Contracts\SleepingOwl
     */
    function framework(): SleepingOwl\Framework\Contracts\SleepingOwl
    {
        return app(SleepingOwl\Framework\Contracts\SleepingOwl::class);
    }
}

if (! function_exists('theme')) {

    /**
     * Получение объекта текущей темы
     *
     * @return SleepingOwl\Framework\Contracts\Themes\Theme
     */
    function theme(): SleepingOwl\Framework\Contracts\Themes\Theme
    {
        return app(SleepingOwl\Framework\Contracts\Themes\Theme::class);
    }
}

if (! function_exists('themeView')) {

    /**
     * @param string $view
     * @param array $data
     * @param array $mergeData
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    function themeView(string $view, $data = [], $mergeData = []): \Illuminate\Contracts\View\View
    {
        return theme()->view($view, $data, $mergeData);
    }
}

if (! function_exists('meta')) {

    /**
     * Получение объекта Meta класса
     *
     * @return SleepingOwl\Framework\Contracts\Template\Meta
     */
    function meta(): SleepingOwl\Framework\Contracts\Template\Meta
    {
        return app(SleepingOwl\Framework\Contracts\Template\Meta::class);
    }
}

if (! function_exists('navigation')) {

    /**
     * Получение объекта навигации
     *
     * @return SleepingOwl\Framework\Contracts\Template\Navigation
     */
    function navigation(): SleepingOwl\Framework\Contracts\Template\Navigation
    {
        return app(SleepingOwl\Framework\Contracts\Template\Navigation::class);
    }
}