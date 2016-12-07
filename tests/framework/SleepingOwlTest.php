<?php

use Mockery as m;
use SleepingOwl\Framework\SleepingOwl;

class SleepingOwlTest extends TestCase
{
    public function testConstructor()
    {
        $framework = $this->getFramework(function ($app) {
            $app->shouldReceive('register')->with(m::on(function ($provider) {
                if (! $provider instanceof \Illuminate\Support\ServiceProvider) {
                    return false;
                }

                return true;
            }));

            $app->shouldReceive('alias');
            $app->shouldReceive('offsetGet')->andReturnUsing(function($key) {
                if ($key == 'config') {
                    return new \Illuminate\Config\Repository(['sleepingowl' => []]);
                }
            });
        });

        $this->assertEquals(SleepingOwl::VERSION, $framework->version());
    }

    public function testVersionMethod()
    {
        $framework = $this->getFramework();
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
        $framework = $this->getFramework(null, $path);

        $this->assertEquals($correctPath, $framework->basePath());
        $this->assertEquals($correctPath, app('sleepingowl.path.base'));
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
        $framework = $this->getFramework();
        $framework->setContext('test', 'test1');

        $this->assertEquals(['test', 'test1'], $framework->context());

        $framework->setContext('test');
        $this->assertEquals(['test', 'test1'], $framework->context());

        $framework->setContext('test2');
        $this->assertEquals(['test', 'test1', 'test2'], $framework->context());
    }

    public function testCheckingContext()
    {
        $framework = $this->getFramework();

        $framework->setContext('test', 'test1');

        $this->assertTrue($framework->context('test'));
        $this->assertTrue($framework->context('test1'));
        $this->assertFalse($framework->context('test2'));

        $framework->setContext('test2');
        $this->assertTrue($framework->context('test2'));

        $this->assertTrue($framework->context('test3', 'test2'));
        $this->assertFalse($framework->context('test3', 'test4'));
    }

    public function testUrlPrefix()
    {
        $framework = $this->getFramework();

        $this->assertEquals('text_backend', $framework->urlPrefix());
    }

    public function testDefaultUrlPrefix()
    {
        $framework = $this->getFramework();

        $this->assertEquals('backend', $framework->defaultUrlPrefix());
    }

    public function testSettingUserModel()
    {
        $class = TestBackendUser::class;

        $this->assertNotEquals($class, SleepingOwl::userModel());
        SleepingOwl::setUserModel($class);

        $this->assertEquals($class, SleepingOwl::userModel());
    }

    public function testResolvingUserModel()
    {
        $this->assertInstanceOf(\SleepingOwl\Framework\Contracts\Auth\User::class, SleepingOwl::user());
    }

    public function testGettingGuard()
    {
        $this->assertEquals('backend', SleepingOwl::guard());
    }

    public function testGettingGuardConfig()
    {
        $this->assertTrue(is_array(SleepingOwl::guardConfig()));
    }

    public function testGettingGuardProvider()
    {
        $this->assertTrue(is_array(SleepingOwl::guardProvider()));
    }

}

class TestBackendUser extends \SleepingOwl\Framework\Entities\User {}