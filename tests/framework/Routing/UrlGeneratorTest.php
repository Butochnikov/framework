<?php

use Mockery as m;

class UrlGeneratorTest extends TestCase
{

    /**
     * @return \SleepingOwl\Framework\Routing\UrlGenerator
     */
    public function getUrlGeneratorObject()
    {
        return $this->getApplication([
            'sleepingowl' => [
                'theme' => [
                    'default' => 'test',
                    'themes' => [
                        'test' => [
                            'class' => TestUrlGeneratorTheme::class
                        ]
                    ]
                ]
            ]
        ])[\SleepingOwl\Framework\Routing\UrlGenerator::class];
    }

    public function testGetPrefix()
    {
        $url = $this->getUrlGeneratorObject();
        $this->assertEquals('test_prefix', $url->prefix());
    }

    public function testAsset()
    {
        $url = $this->getUrlGeneratorObject();

        $this->assertEquals('http://www.foo.com/dir/test.js', $url->asset('test.js'));
        $this->assertEquals('http://test.com/script.js', $url->asset('http://test.com/script.js'));
    }

    public function testAssetFrom()
    {
        $url = $this->getUrlGeneratorObject();

        $this->assertEquals('http://hello/dir/test.js', $url->assetFrom('https://hello', 'test.js'));
    }

    public function testTo()
    {
        $url = $this->getUrlGeneratorObject();

        $this->assertEquals('http://www.foo.com/test_prefix/test/dir', $url->to('test/dir'));
        $this->assertEquals('http://www.foo.com/test_prefix/test/dir', $url->to('/test/dir'));
        $this->assertEquals('http://test/dir', $url->to('http://test/dir'));
    }

    public function testSecure()
    {
        $url = $this->getUrlGeneratorObject();

        $this->assertEquals('https://www.foo.com/test_prefix/test/dir', $url->secure('test/dir'));
        $this->assertEquals('https://test/dir', $url->secure('https://test/dir'));
    }

    public function testPrevious()
    {
        $url = $this->getUrlGeneratorObject();

        $this->assertEquals('http://www.site.com/hello/world', $url->previous());

        $url->getRequest()->headers->remove('referer');
        $this->assertEquals('http://test', $url->previous('http://test'));
        $this->assertEquals('http://www.foo.com/test_prefix/fallback/path', $url->previous('fallback/path'));
        $this->assertEquals('http://www.foo.com/test_prefix', $url->previous());
    }

    public function testCurrent()
    {
        $url = $this->getUrlGeneratorObject();

        $this->assertEquals('http://www.foo.com/hello/world', $url->current());
    }
}

class TestUrlGeneratorTheme implements \SleepingOwl\Framework\Contracts\Themes\Theme
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
        return 'dir/';
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