<?php
namespace SleepingOwl\Framework\Repositories;

use SleepingOwl\Framework\Contracts\Repositories\UserMetaRepository as UserMetaRepositoryContract;
use SleepingOwl\Framework\Entities\UserMeta;

class UserMetaRepository implements UserMetaRepositoryContract
{
    /**
     * @var UserMeta
     */
    private $model;

    /**
     * @param UserMeta $model
     */
    public function __construct(UserMeta $model)
    {
        $this->model = $model;
    }

    /**
     * Получение данных по ключу
     *
     * @param int $userId
     * @param string $key
     *
     * @return UserMeta
     */
    public function getByKey(int $userId, string $key): UserMeta
    {
        return $this->model
            ->where('user_id', $userId)
            ->where('key', $key)
            ->firstOrFail();
    }

    /**
     * Сохоранение или обновление параметров пользователя
     *
     * @param int $userId
     * @param string $key
     * @param array $data
     *
     * @return UserMeta
     */
    public function store(int $userId, string $key, array $data): UserMeta
    {
        return $this->model
            ->updateOrCreate(
                ['user_id' => $userId, 'key' => $key],
                ['data' => $data]
            );
    }

    /**
     * Удаление данных
     *
     * @param int $userId
     * @param string $key
     *
     * @return bool
     */
    public function delete(int $userId, string $key): bool
    {
        return $this->model->where('user_id', $userId)
            ->where('key', $key)
            ->delete();
    }
}