<?php
namespace SleepingOwl\Api\Transformers;

use SleepingOwl\Api\Transformer;
use SleepingOwl\Framework\Entities\Notification as NotificationEntity;
use SleepingOwl\Framework\Notifications\NotificationToHtmlMapper;

class Notification extends Transformer
{
    /**
     * @param NotificationEntity $notification
     *
     * @return array
     */
    public function transform(NotificationEntity $notification): array
    {
        $data['id']         = $notification->id;
        $data['html']       = (new NotificationToHtmlMapper($notification))->toHtml();
        $data['created_at'] = $notification->created_at->toDateTimeString();
        $data['read']       = ! is_null($notification->read_at);

        return $data;
    }

    /**
     * @return string
     */
    public function type(): string
    {
        return 'notification';
    }
}