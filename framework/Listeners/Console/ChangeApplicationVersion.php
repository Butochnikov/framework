<?php

namespace SleepingOwl\Framework\Listeners\Console;

use Illuminate\Console\Events\ArtisanStarting;
use SleepingOwl\Framework\Contracts\SleepingOwl;

class ChangeApplicationVersion
{
    /**
     * @var SleepingOwl
     */
    private $framework;

    /**
     * @param SleepingOwl $framework
     */
    public function __construct(SleepingOwl $framework)
    {
        $this->framework = $framework;
    }

    /**
     * @param ArtisanStarting $event
     */
    public function handle(ArtisanStarting $event)
    {
        $artisan = $event->artisan;

        $artisan->setVersion(
            $artisan->getVersion().'</comment> with <info>'.$this->framework->name().'</info>'
        );
    }
}