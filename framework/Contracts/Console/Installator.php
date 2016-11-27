<?php
namespace SleepingOwl\Framework\Contracts\Console;

interface Installator
{
    /**
     *
     * @return void
     */
    public function showInfo();

    /**
     * Install the components.
     *
     * @return void
     */
    public function install();
}