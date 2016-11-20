<?php

namespace SleepingOwl\Framework\Contracts\Console;

interface Installator
{

    public function showInfo();

    /**
     * Install the components.
     *
     * @return void
     */
    public function install();
}