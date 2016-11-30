<?php
namespace SleepingOwl\Framework\Console\Installation;

class InstallMigrations extends Installator
{

    public function showInfo()
    {
        $this->command->line('Installing Database Migrations: <info>✔</info>');
    }

    /**
     * Install the components.
     *
     * @return void
     */
    public function install()
    {
        $this->command->call('migrate', ['--force' => 'true']);
    }
}