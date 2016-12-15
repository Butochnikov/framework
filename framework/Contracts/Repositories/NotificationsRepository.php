<?php namespace SleepingOwl\Framework\Contracts\Repositories;

use Illuminate\Database\Eloquent\Collection;
use SleepingOwl\Framework\Entities\Notification;
use SleepingOwl\Framework\Entities\User;

interface NotificationsRepository
{
    /**
     * Получение уведомления по ID
     *
     * @param User $user
     * @param string $id
     *
     * @return Notification
     */
    public function getById(User $user, string $id): Notification;

    /**
     *
     *
     * @param User $user
     * @param int $hours Кол-во часов прошедшее с моента прочтения
     *
     * @return Collection
     */
    public function recent(User $user, $hours = 24): Collection;

    /**
     * Пометка уведомлений прочитанными по массиву ID
     *
     * @param User $user
     * @param array $ids
     *
     * @return void
     */
    public function markAsRead(User $user, array $ids);
}