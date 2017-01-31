<?php

use Mockery as m;
use Illuminate\Foundation\Application;
use SleepingOwl\Framework\Themes\ThemesManager;

class ThemeManagerTest extends TestCase
{
    /**
     * @param array $config
     *
     * @return Application
     */
    protected function getApplication(array $config = null)
    {
        return parent::getApplication($config ?: [
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
    }

    /**
     * @covers ThemesManager::getDefaultTheme()
     * @covers ThemesManager::setDefaultTheme()
     */
    public function testDefaultTheme()
    {
        $manager = $this->getThemeManager(
            $this->getApplication([
                'sleepingowl' => [
                    'theme' => [
                        'default' => 'testTheme'
                    ]
                ]
            ])
        );

        $this->assertEquals('testTheme', $manager->getDefaultTheme());
        $manager->setDefaultTheme('anotherTestTheme');

        $this->assertEquals('anotherTestTheme', $manager->getDefaultTheme());
    }

    public function testResolvingThemeObject()
    {
        $events = m::mock(\Illuminate\Contracts\Events\Dispatcher::class);
        $events->shouldReceive('fire')->once()->with(\SleepingOwl\Framework\Events\ThemeLoaded::class);
        $manager = $this->getThemeManager(null, $events);

        $this->assertInstanceOf(TestThemeTestManager::class, $manager->theme());
    }

    public function testCallingThemeMethods()
    {
        $manager = $this->getThemeManager();
        $this->assertEquals('test theme', $manager->name());
    }

    /**
     * @expectedException Symfony\Component\OptionsResolver\Exception\MissingOptionsException
     */
    public function testNotFoundThemeObject()
    {
        $manager = $this->getThemeManager($this->getApplication([
            'sleepingowl' => [
                'theme' => [
                    'default' => 'test1',
                ]
            ]
        ]));

        $manager->theme();
    }

    /**
     * @expectedException SleepingOwl\Framework\Exceptions\Themes\ThemeNotFound
     */
    public function testThemeClassNotFound()
    {
        $manager = $this->getThemeManager($this->getApplication([
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
        ]));

        $manager->theme();
    }

    /**
     * @expectedException Symfony\Component\OptionsResolver\Exception\MissingOptionsException
     */
    public function testMissedThemeConfigClassParameter()
    {
        $manager = $this->getThemeManager($this->getApplication([
            'sleepingowl' => [
                'theme' => [
                    'default' => 'test1',
                    'themes' => [
                        'test1' => []
                    ]
                ]
            ]
        ]));

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