<?php
namespace SleepingOwl\Framework\Notifications;

use Illuminate\Notifications\Notification;

class FrameworkInstalled extends Notification
{

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['backend'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toDatabase($notifiable)
    {
        return [
            'icon' => 'bar chart',
            'text' => 'Framework installed'
        ];
    }
}