<?php
namespace SleepingOwl\Framework\Configuration;

use SleepingOwl\Framework\Contracts\Routing\UrlGenerator;
use SleepingOwl\Framework\Contracts\Themes\Factory as ThemeManager;

trait ProvidesScriptVariables
{
    /**
     * Получение массива глобальных переменных для JavaScript
     *
     * @return array
     */
    public function scriptVariables(): array
    {
        return [
            'debug' => config('app.debug'),
            'env' => $this->app->environment(),
            'locale' => $this->app['translator']->getLocale(),
            'url_prefix' => $this->urlPrefix(),
            'url' => $this->app['url']->to(''),
            'backend_url' => $this->app[UrlGenerator::class]->to(''),
            'theme' => $this->app[ThemeManager::class]->theme()->toArray(),
            'userId' => $this->app['auth']->guard(static::guard())->id(),
        ];
    }
}