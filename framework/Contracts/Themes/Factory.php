<?php
namespace SleepingOwl\Framework\Contracts\Themes;

interface Factory
{

    /**
     * Получение объекта текущей темы
     *
     * @return Theme
     */
    public function theme();

    /**
     * Получение ключа темы по умолчанию
     *
     * @return string
     */
    public function getDefaultTheme() : string;

    /**
     * Изменение темы по умолчанию
     *
     * @param  string $name
     *
     * @return void
     */
    public function setDefaultTheme(string $name);
}