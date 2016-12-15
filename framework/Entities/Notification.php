<?php
namespace SleepingOwl\Framework\Entities;

use Illuminate\Notifications\DatabaseNotification;

class Notification extends DatabaseNotification
{

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'sof_notifications';

}