<?php

use Mockery as m;

class ThemeTest extends TestCase
{

    /**
     * @var \Illuminate\Foundation\Application
     */
    protected $app;

    public function setUp()
    {
        $this->app = $this->getApplication([
            'sleepingowl' => [
                'theme' => [
                    'default' => 'test',
                    'themes' => [
                        'test' => [
                            'class' => TestTheme::class
                        ]
                    ]
                ]
            ]
        ]);
    }

    /**
     * @param array $config
     *
     * @return \SleepingOwl\Framework\Contracts\Themes\Theme
     */
    public function getThemeObject(array $config = [])
    {
        $meta = m::mock(SleepingOwl\Framework\Contracts\Template\Meta::class);

        $meta->shouldReceive('addJs')->andReturnSelf();
        $meta->shouldReceive('addCss')->andReturnSelf();

        $framework = m::mock(SleepingOwl\Framework\SleepingOwl::class);
        $framework->shouldReceive('name')->andReturn('framework v.0.0.1');

        $theme = new SleepingOwl\Framework\Themes\AdminLteTheme(
            $framework,
            $meta,
            $navigation = m::mock(SleepingOwl\Framework\Contracts\Template\Navigation::class),
            $view = m::mock(Illuminate\Contracts\View\Factory::class),
            $config
        );

        return $theme;
    }

    public function testTitleGenerating()
    {
        $theme = $this->getThemeObject();

        $this->assertEquals('test | framework v.0.0.1', $theme->title('test'));
        $this->assertEquals('framework v.0.0.1', $theme->title());
    }

    public function testAssetPathGenerating()
    {
        $theme = $this->getThemeObject();

        $this->assertEquals($theme->assetDir().'/test', $theme->assetPath('test'));
        $this->assertEquals($theme->assetDir().'/test', $theme->assetPath('/test'));
        $this->assertEquals($theme->assetDir(), $theme->assetPath());
    }

    public function testAssetGenerating()
    {
        $theme = $this->getThemeObject();

        $this->assertEquals($this->app[\SleepingOwl\Framework\Routing\UrlGenerator::class]->asset('test.js'), $theme->asset('test.js'));
    }

    public function testViewPathGenerating()
    {
        $theme = $this->getThemeObject();

        $this->assertEquals($theme->viewNamespace().'app', $theme->viewPath('app'));
    }

    public function testGettingThemeConfig()
    {
        $theme = $this->getThemeObject();

        $this->assertInstanceOf(\Illuminate\Config\Repository::class, $theme->getConfig());
    }

    public function testGetLogo()
    {
        $theme = $this->getThemeObject();
        $this->assertNotNull($theme->logo());
    }

    public function testGetLogoSmall()
    {
        $theme = $this->getThemeObject();
        $this->assertNotNull($theme->logoSmall());
    }

    public function testOverrideLogo()
    {
        $newLogo = '<img src="new-path-to-logo.jpg" />';
        $theme = $this->getThemeObject([
            'logo' => $newLogo
        ]);

        $this->assertEquals($newLogo, $theme->logo());
        $this->assertNotEquals($newLogo, $theme->logoSmall());
    }

    public function testOverrideLogoSmall()
    {
        $newLogo = '<img src="new-path-to-logo.jpg" />';
        $theme = $this->getThemeObject([
            'logo_small' => $newLogo
        ]);

        $this->assertEquals($newLogo, $theme->logoSmall());
        $this->assertNotEquals($newLogo, $theme->logo());
    }
}

class TestTheme implements \SleepingOwl\Framework\Contracts\Themes\Theme
{
    public function name(): string
    {
        return 'test theme';
    }

    public function logo(): string{}
    public function logoSmall(): string{}
    public function getConfig(): \Illuminate\Contracts\Config\Repository{}
    public function title(string $title = null): string {}

    public function assetPath(string $path = null): string {
        return $this->assetDir().$path;
    }

    public function assetDir(): string{
        return 'custom-dir/';
    }
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