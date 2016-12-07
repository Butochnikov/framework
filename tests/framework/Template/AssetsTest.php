<?php

use Mockery as m;

class AssetsTest extends TestCase
{
    /**
     * @return \SleepingOwl\Framework\Template\Assets
     */
    protected function getAssets()
    {
        return new \SleepingOwl\Framework\Template\Assets(
            m::mock(\KodiCMS\Assets\Contracts\PackageManagerInterface::class)
        );
    }
    public function testPuttingGlobalVars()
    {
        $assets = $this->getAssets();

        $assets->putGlobalVar('testKey', 'testValue');
        $this->assertEquals(['testKey' => 'testValue'], $assets->globalVars());

        $assets->putGlobalVar('testKey', 'testValue1');
        $this->assertEquals(['testKey' => 'testValue1'], $assets->globalVars());

        $assets->putGlobalVar('testKey1', ['testValue', 'testValue1']);
        $this->assertEquals(['testKey' => 'testValue1', 'testKey1' => ['testValue', 'testValue1']], $assets->globalVars());
    }

    public function testRenderingGlobalVars()
    {
        $assets = $this->getAssets();

        $assets->putGlobalVar('testKey', 'testValue');
        $assets->putGlobalVar('testKey1', ['testValue', 'testValue1']);

        $this->assertEquals(
            '<script>window.GlobalConfig = {"testKey":"testValue","testKey1":["testValue","testValue1"]};</script>',
            $assets->renderGlobalVars()
        );
    }
}