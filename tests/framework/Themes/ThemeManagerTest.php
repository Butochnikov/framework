<?php

use Illuminate\Foundation\Application;
use Mockery as m;
use SleepingOwl\Framework\Themes\ThemesManager;

class ThemeManagerTest extends PHPUnit_Framework_TestCase
{
    public function tearDown()
    {
        m::close();
    }

    /**
     * @return Application
     */
    protected function getApplication()
    {
        $app = new Application();
        $app['config'] = new \Illuminate\Config\Repository([
            'sleepingowl' => [
                'theme' => [
                    'default' => 'test',
                    'themes' => [
                        'test' => [
                            'class' => TestThemeTestManager::class
                        ]
                    ]
                ]
            ]
        ]);

        $app['request'] = m::mock(\Illuminate\Http\Request::class);
        $app['SleepingOwl\Framework\Contracts\Routing\Router'] = m::mock(\SleepingOwl\Framework\Contracts\Routing\Router::class);

        return $app;
    }

    /**
     * @param Application|null $app
     *
     * @return ThemesManager
     */
    protected function makeManager(Application $app = null, $events = null)
    {
        if (! $events) {
            $events = m::mock(\Illuminate\Contracts\Events\Dispatcher::class);
            $events->shouldReceive('fire');
        }

        return new ThemesManager(
            $app ?: $this->getApplication(),
            $events
        );
    }

    /**
     * @covers ThemesManager::getDefaultTheme()
     * @covers ThemesManager::setDefaultTheme()
     */
    public function testDefaultTheme()
    {
        $app = new Application();
        $app['config'] =  new \Illuminate\Config\Repository([
            'sleepingowl' => [
                'theme' => [
                    'default' => 'testTheme'
                ]
            ]
        ]);

        $manager = $this->makeManager($app);

        $this->assertEquals('testTheme', $manager->getDefaultTheme());
        $manager->setDefaultTheme('anotherTestTheme');

        $this->assertEquals('anotherTestTheme', $manager->getDefaultTheme());
    }

    public function testResolvingThemeObject()
    {
        $events = m::mock(\Illuminate\Contracts\Events\Dispatcher::class);
        $events->shouldReceive('fire')->once()->with(\SleepingOwl\Framework\Events\ThemeLoaded::class);

        $manager = $this->makeManager(null, $events);
        $this->assertInstanceOf(TestThemeTestManager::class, $manager->theme());
    }

    public function testCallingThemeMethods()
    {
        $manager = $this->makeManager();
        $this->assertEquals('test theme', $manager->name());
    }

    /**
     * @expectedException SleepingOwl\Framework\Exceptions\Themes\ThemeNotFound
     */
    public function testNotFoundThemeObject()
    {
        $app = new Application();
        $app['config'] =  new \Illuminate\Config\Repository([
            'sleepingowl' => [
                'theme' => [
                    'default' => 'test1',
                ]
            ]
        ]);

        $manager = $this->makeManager($app);
        $manager->theme();
    }

    /**
     * @expectedException SleepingOwl\Framework\Exceptions\Themes\ThemeNotFound
     */
    public function testThemeClassNotFound()
    {
        $app = new Application();
        $app['config'] =  new \Illuminate\Config\Repository([
            'sleepingowl' => [
                'theme' => [
                    'default' => 'test1',
                    'themes' => [
                        'test1' => [
                            'class' => 'UndefinedTestTheme'
                        ]
                    ]
                ]
            ]
        ]);

        $manager = $this->makeManager($app);
        $manager->theme();
    }

    /**
     * @expectedException Symfony\Component\OptionsResolver\Exception\MissingOptionsException
     */
    public function testMissedThemeConfigClassParameter()
    {
        $app = new Application();
        $app['config'] =  new \Illuminate\Config\Repository([
            'sleepingowl' => [
                'theme' => [
                    'default' => 'test1',
                    'themes' => [
                        'test1' => []
                    ]
                ]
            ]
        ]);

        $manager = $this->makeManager($app);
        $manager->theme();
    }
}

class TestThemeTestManager implements \SleepingOwl\Framework\Contracts\Themes\Theme
{
    public function name(): string
    {
        return 'test theme';
    }

    public function logo(): string{}
    public function logoSmall(): string{}
    public function getConfig(): \Illuminate\Contracts\Config\Repository{}
    public function title(string $title = null): string {}
    public function assetPath(string $path = null): string {}
    public function assetDir(): string{}
    public function asset(string $path, bool $secure = null): string {}
    public function viewNamespace(): string{}
    public function viewPath($view): string {}
    public function view($view, $data = [], $mergeData = []): \Illuminate\Contracts\View\View {}
    public function renderMeta(string $title = null): string {}
    public function renderNavigation(): string {}
    public function toArray() {}
    public function version(): string {}
    public function longName(): string{}
    public function homepage(): string{}
}