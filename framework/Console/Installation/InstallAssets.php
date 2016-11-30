<?php
namespace SleepingOwl\Framework\Console\Installation;

class InstallAssets extends Installator
{

    public function showInfo()
    {
        $this->command->line('Install Assets: <info>✔</info>');
    }

    /**
     * Install the components.
     *
     * @return void
     */
    public function install()
    {
        $this->command->call('vendor:publish', [
            '--tag' => 'sleepingowl-assets',
        ]);
    }
}