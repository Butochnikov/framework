<?php
namespace SleepingOwl\Framework\Contracts\Console;

interface Installator
{
    /**
     * Вывод информации о текущей конфигурации
     *
     * @return void
     */
    public function showInfo();

    /**
     * Установка компонентов текущей конфигурации
     *
     * @return void
     */
    public function install();
}