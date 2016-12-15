<?php
namespace SleepingOwl\Framework\Notifications;

use Illuminate\Database\Eloquent\Relations\MorphMany;
use SleepingOwl\Framework\Entities\Notification;

trait HasBackendDatabaseNotifications
{
    /**
     * @return MorphMany
     */
    public function routeNotificationForBackend()
    {
        return $this->backendNotifications();
    }

    /**
     * Get the entity's notifications.
     */
    public function backendNotifications()
    {
        return $this->morphMany(Notification::class, 'notifiable')
            ->orderBy('created_at', 'desc');
    }

    /**
     * Get the entity's read notifications.
     */
    public function readBackendNotifications()
    {
        return $this->morphMany(Notification::class, 'notifiable')
            ->whereNotNull('read_at')
            ->orderBy('created_at', 'desc');
    }

    /**
     * Get the entity's unread notifications.
     */
    public function unreadBackendNotifications()
    {
        return $this->morphMany(Notification::class, 'notifiable')
            ->whereNull('read_at')
            ->orderBy('created_at', 'desc');
    }
}
