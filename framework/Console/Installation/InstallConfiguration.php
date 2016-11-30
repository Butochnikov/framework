<?php
namespace SleepingOwl\Framework\Console\Installation;

class InstallConfiguration extends Installator
{

    public function showInfo()
    {
        $this->command->line('Install Configuration: <info>✔</info>');
    }

    /**
     * Install the components.
     *
     * @return void
     */
    public function install()
    {
        $this->command->call('vendor:publish', [
            '--tag' => 'sleepingowl-config',
        ]);
    }

    /**
     * При возврате методом true данный компонент будет пропущен
     *
     * @return bool
     */
    public function installed(): bool
    {
        return false;
    }
}