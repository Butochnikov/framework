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
     */
    public function __construct($command)
    {
        $this->command = $command;
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