<?php
namespace SleepingOwl\Framework\Configuration;

trait ManagesAppDetails
{

    /**
     * URL префикс админ панели по умочанию
     *
     * @return string
     */
    public static function defaultUrlPrefix(): string
    {
        return 'backend';
    }

    /**
     * URL префикс админ панели
     *
     * @return string
     */
    public function urlPrefix(): string
    {
        return $this->config()->get('url_prefix', static::defaultUrlPrefix());
    }
}
