<?php
namespace SleepingOwl\Framework\Console\Installation;

abstract class Installator implements \SleepingOwl\Framework\Contracts\Console\Installator
{
    /**
     * The console command instance.
     *
     * @var \Illuminate\Console\Command  $command
     */
    protected $command;

    /**
     * Create a new installer instance.
     *
     * @param  \Illuminate\Console\Command  $command
     * @return void
     */
    public function __construct($command)
    {
        $this->command = $command;
        $this->showInfo();
    }
}