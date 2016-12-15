<?php
namespace SleepingOwl\Framework\Console\Installation;

class InstallModules extends Installator
{

    public function showInfo()
    {
        $this->command->line('Install modules: <info>✔</info>');
    }

    /**
     * Install the components.
     *
     * @return void
     */
    public function install()
    {
        $this->command->call('module:setup');
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