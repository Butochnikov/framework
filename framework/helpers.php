<?php

if (! defined('SLEEPINGOWL_PATH')) {
    define('SLEEPINGOWL_PATH', realpath(__DIR__.'/../'));
}

if (! function_exists('framework')) {

    /**
     * @return SleepingOwl\Framework\Contracts\SleepingOwl
     */
    function framework()
    {
        return app(SleepingOwl\Framework\Contracts\SleepingOwl::class);
    }
}

if (! function_exists('theme')) {

    /**
     * @return SleepingOwl\Framework\Contracts\Themes\Theme
     */
    function theme()
    {
        return app(SleepingOwl\Framework\Contracts\Themes\Theme::class);
    }
}