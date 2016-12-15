<?php
namespace SleepingOwl\Framework\Notifications;

use Illuminate\Contracts\Support\Htmlable;
use SleepingOwl\Framework\Entities\Notification;

class NotificationToHtmlMapper implements Htmlable
{

    /**
     * @var Notification
     */
    private $notification;

    /**
     * @param Notification $notification
     */
    public function __construct(Notification $notification)
    {
        $this->notification = $notification;
    }

    /**
     * Get content as a string of HTML.
     *
     * @return string
     */
    public function toHtml()
    {
        return themeView($this->getViewPath($this->notification->type), [
            'notification' => $this->notification,
        ])->render();
    }

    /**
     * @param string $notificationType
     *
     * @return string
     */
    protected function getViewPath(string $notificationType): string
    {
        $template = 'notifications.'.snake_case(class_basename($notificationType));

        if (! view()->exists(theme()->viewPath($template))) {
            $template = 'notifications.default';
        }

        return $template;
    }
}