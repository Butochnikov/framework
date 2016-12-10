<?php namespace SleepingOwl\Framework\Contracts\Repositories;

use SleepingOwl\Framework\Entities\UserMeta;

interface UserMetaRepository
{
    /**
     * Получение данных по ключу
     *
     * @param int $userId
     * @param string $key
     *
     * @return UserMeta
     */
    public function getByKey(int $userId, string $key): UserMeta;

    /**
     * Сохоранение или обновление параметров пользователя
     *
     * @param int $userId
     * @param string $key
     * @param array $data
     *
     * @return UserMeta
     */
    public function store(int $userId, string $key, array $data): UserMeta;

    /**
     * Удаление данных
     *
     * @param int $userId
     * @param string $key
     *
     * @return bool
     */
    public function delete(int $userId, string $key): bool;
}