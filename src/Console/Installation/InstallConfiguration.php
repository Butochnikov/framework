<?php

namespace SleepingOwl\Framework\Console\Installation;

use SleepingOwl\Framework\Contracts\Console\Installator;

class InstallConfiguration implements Installator
{

    public function showInfo()
    {
        $this->command->line('Updating Configuration Values: <info>✔</info>');
    }

    /**
     * Install the components.
     *
     * @return void
     */
    public function install()
    {
        // TODO: Implement install() method.
    }
}