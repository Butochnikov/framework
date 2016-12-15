<?php
namespace SleepingOwl\Framework\Repositories;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use SleepingOwl\Framework\Entities\Notification;
use SleepingOwl\Framework\Entities\User;

class NotificationsRepository implements \SleepingOwl\Framework\Contracts\Repositories\NotificationsRepository
{
    /**
     * Получение уведомления по ID
     *
     * @param User $user
     * @param string $id
     *
     * @return Notification
     */
    public function getById(User $user, string $id): Notification
    {
        return $user->unreadBackendNotifications()->findOrFail($id);
    }

    /**
     *
     *
     * @param User $user
     * @param int $hours Кол-во часов прошедшее с моента прочтения
     *
     * @return Collection
     */
    public function recent(User $user, $hours = 24): Collection
    {
        return $user->backendNotifications()->where(function($query) use($hours) {
            $query
                ->whereNull('read_at')
                ->orWhere('read_at', '>', Carbon::now()->subHours($hours)->toDateString());
        })->get();
    }

    /**
     * Пометка уведомлений прочитанными по массиву ID
     *
     * @param User $user
     * @param array $ids
     *
     * @return void
     */
    public function markAsRead(User $user, array $ids)
    {
        $user
            ->unreadBackendNotifications()
            ->whereIn('id', $ids)
            ->update(['read_at' => Carbon::now()]);
    }
}