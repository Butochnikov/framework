<?php
namespace SleepingOwl\Framework\Configuration;

use Illuminate\Contracts\Auth\Authenticatable;

trait ManagesAuthOptions
{

    /**
     * Получение названия класса модели пользователя админ панели
     *
     * @return string
     */
    public static function userModel(): string
    {
        return \SleepingOwl\Framework\Entities\User::class;
    }

    /**
     * Получение объекта пользователя админ панели
     *
     * @return Authenticatable
     */
    public static function user(): Authenticatable
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
        return 'backend';
    }

    /**
     * Получение настроек для гарда
     *
     * @return array
     */
    public function guardConfig(): array
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
    public function guardProvider(): array
    {
        return $this->config->get('guard_provider', [
            'driver' => 'eloquent',
            'model' => static::userModel()
        ]);
    }
}
