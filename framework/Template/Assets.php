<?php
namespace SleepingOwl\Framework\Template;

use KodiCMS\Assets\Assets as BaseAssets;
use KodiCMS\Assets\Html;
use SleepingOwl\Framework\Contracts\Template\Assets as AssetsContract;

class Assets extends BaseAssets implements AssetsContract
{

    /**
     * @var array
     */
    protected $globalVars = [];

    /**
     * Добавление глобальной переменной
     *
     * @param string $key
     * @param mixed $value
     *
     * @return self
     */
    public function putGlobalVar(string $key, $value)
    {
        $this->globalVars[$key] = $value;

        return $this;
    }

    /**
     * Получение массива глобальных перменных
     *
     * @return array
     */
    public function globalVars(): array
    {
        return $this->globalVars;
    }

    /**
     * @return string
     */
    public function render()
    {
        return $this->renderGlobalVars().PHP_EOL.parent::render();
    }

    /**
     * @return string
     */
    public function renderGlobalVars(): string
    {
        $json = json_encode($this->globalVars);

        return (new Html())->vars("{$this->namespace}.GlobalConfig = {$json};");
    }

}