<?php
namespace SleepingOwl\Framework\Contracts\Template;

use KodiCMS\Assets\Contracts\AssetsInterface;

interface Assets extends AssetsInterface
{

    /**
     * @param string $key
     * @param mixed $value
     *
     * @return self
     */
    public function putGlobalVar(string $key, $value);

    /**
     * @return string
     */
    public function renderGlobalVars(): string;
}