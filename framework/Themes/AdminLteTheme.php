<?php
namespace SleepingOwl\Framework\Themes;

class AdminLteTheme extends Theme
{
    /**
     * Получение названия текущего шаблона
     *
     * @return string
     */
    public function name(): string
    {
        return 'admin-lte';
    }

    /**
     * Получение относительного пути хранения asset файлов
     *
     * @return string
     */
    public function assetDir(): string
    {
        return 'vendor/sleepingowl/admin-lte';
    }

    /**
     * Получение неймспейса для view шаблонов
     *
     * @return string
     */
    public function namespace(): string
    {
        return 'sleepingowl';
    }
}