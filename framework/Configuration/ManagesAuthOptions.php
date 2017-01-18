<?php
namespace SleepingOwl\Framework\Configuration;

use SleepingOwl\Framework\Contracts\Auth\User as UserContract;

trait ManagesAuthOptions
{
    /**
     * Класс пользователя используемы админ панелью для авторизации
     *
     * Должен содержать интерфейс `SleepingOwl\Framework\Contracts\Auth\User`
     *
     * @var string
     */
    protected static $userModel = \SleepingOwl\Framework\Entities\User::class;

    /**
     * Название гарда, отвечающего за доступ в админ панель
     *
     * @var string
     */
    protected static $authGuard = 'backend';

    /**
     * Получение названия класса модели пользователя админ панели
     *
     * @return string
     */
    public static function userModel(): string
    {
        return static::$userModel;
    }

    /**
     * Переопределение класса пользователя
     *
     * @param string $class
     * @return void
     */
    public static function setUserModel(string $class)
    {
        static::$userModel = $class;
    }

    /**
     * Получение объекта пользователя админ панели
     *
     * @return UserContract
     */
    public static function user(): UserContract
    {
        $model = static::userModel();

        return new $model();
    }

    /**
     * Получение названия гарда для админ панели
     *
     * @return string
     */
    public static function guard(): string
    {
        return static::$authGuard;
    }

    /**
     * Получение настроек для гарда
     *
     * @return array
     */
    public static function guardConfig(): array
    {
        return [
            'driver' => 'session',
            'provider' => 'backend_users',
        ];
    }

    /**
     * Получение настроек провайдера для гарда
     *
     * @return array
     */
    public static function guardProvider(): array
    {
        return [
            'driver' => 'eloquent',
            'model' => static::userModel()
        ];
    }
}
