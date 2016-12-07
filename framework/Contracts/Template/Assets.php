<?php
namespace SleepingOwl\Framework\Contracts\Template;

use KodiCMS\Assets\Contracts\AssetsInterface;

interface Assets extends AssetsInterface
{

    /**
     * Добавление глобальной переменной
     *
     * @param string $key
     * @param mixed $value
     *
     * @return self
     */
    public function putGlobalVar(string $key, $value);

    /**
     * Получение массива глобальных перменных
     *
     * @return array
     */
    public function globalVars(): array;

    /**
     * @return string
     */
    public function renderGlobalVars(): string;
}