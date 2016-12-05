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
     * @return string
     */
    public function render()
    {
        return $this->renderStyles()
            .PHP_EOL.$this->renderGlobalVars()
            .PHP_EOL.$this->renderVars()
            .PHP_EOL.$this->renderScripts();
    }

    /**
     * @return string
     */
    public function renderGlobalVars(): string
    {
        $json = json_encode($this->globalVars, JSON_PRETTY_PRINT);

        return (new Html())->vars("{$this->namespace}.GlobalConfig = {$json};");
    }

}