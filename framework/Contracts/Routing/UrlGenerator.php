<?php
namespace SleepingOwl\Framework\Contracts\Routing;

use Illuminate\Contracts\Routing\UrlGenerator as BaseUrlGeneratorContract;
use SleepingOwl\Framework\Contracts\Themes\Theme as ThemeContract;

interface UrlGenerator extends BaseUrlGeneratorContract
{
    /**
     * Получение префикса админ панели
     *
     * @return string
     */
    public function prefix(): string;

    /**
     * Указание текущей темы для генерации правильных путей до asset
     *
     * @param ThemeContract $theme
     * @return void
     */
    public function setTheme(ThemeContract $theme);
}