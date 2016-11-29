<?php

use Mockery as m;
use SleepingOwl\Framework\SleepingOwl;
use Illuminate\Foundation\Application;

class SleepingOwlTest extends PHPUnit_Framework_TestCase
{

    public function tearDown()
    {
        m::close();
    }

    public function testConstructor()
    {
        $app = m::mock(Application::class);
        $app->shouldReceive('register')->with(m::on(function ($provider) {
            if (! $provider instanceof \Illuminate\Support\ServiceProvider) {
                return false;
            }

            return true;
        }));

        $app->shouldReceive('alias');
        $framework = new SleepingOwl($app);
        $this->assertEquals(SleepingOwl::VERSION, $framework->version());
    }

    public function testVersionMethod()
    {
        $framework = new SleepingOwl(new Application());
        $this->assertEquals(SleepingOwl::VERSION, $framework->version());
    }

    /**
     * @covers SleepingOwl::setBasePath()
     * @covers SleepingOwl::basePath()
     *
     * @dataProvider pathsProvider
     */
    public function testSettingBasePath($path, $correctPath)
    {
        $framework = new SleepingOwl($app = new Application(), $path);

        $this->assertEquals($correctPath, $framework->basePath());
        $this->assertEquals($correctPath, $app['sleepingowl.path.base']);
    }

    public function pathsProvider()
    {
        return [
            ['folder1/folder2/', 'folder1/folder2'],
            ['folder1/folder2', 'folder1/folder2'],
            ['folder1\folder2\\', 'folder1\folder2']
        ];
    }

    public function testSettingContext()
    {
        $framework = new SleepingOwl(new Application());
        $framework->setContext('test', 'test1');

        $this->assertEquals(['test', 'test1'], $framework->context());

        $framework->setContext('test');
        $this->assertEquals(['test', 'test1'], $framework->context());

        $framework->setContext('test2');
        $this->assertEquals(['test', 'test1', 'test2'], $framework->context());
    }

    public function testCheckingContext()
    {
        $framework = new SleepingOwl(new Application());
        $framework->setContext('test', 'test1');

        $this->assertTrue($framework->context('test'));
        $this->assertTrue($framework->context('test1'));
        $this->assertFalse($framework->context('test2'));

        $framework->setContext('test2');
        $this->assertTrue($framework->context('test2'));

        $this->assertTrue($framework->context('test3', 'test2'));
        $this->assertFalse($framework->context('test3', 'test4'));
    }
}