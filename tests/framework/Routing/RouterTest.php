<?php

use Mockery as m;

class RouterTest extends PHPUnit_Framework_TestCase
{

    /**
     * @var Illuminate\Routing\Router
     */
    protected $router;

    public function tearDown()
    {
        m::close();
    }

    /**
     * @param string $urlPrefix
     *
     * @return \SleepingOwl\Framework\Routing\Router
     */
    public function getRouterObject($urlPrefix = 'test_preffix')
    {
        $router = new SleepingOwl\Framework\Routing\Router(
            $this->router = new TestRouterRouterTest(),
            $urlPrefix
        );

        return $router;
    }

    public function testGetPrefix()
    {
        $router = $this->getRouterObject();

        $this->assertEquals('test_preffix', $router->getUrlPrefix());
    }

    public function testAddingBackendGroup()
    {
        $router = $this->getRouterObject();
        $router->backendGroup([
            'test' => 'test'
        ], function() {});

        $this->assertEquals([
            "test" => "test",
            "middleware" => "backend",
            "prefix" => "test_preffix",
        ], $this->router->data);

        $router->backendGroup(['middleware' => 'test'], function() {});

        $this->assertEquals([
            "middleware" => ["test", "backend"],
            "prefix" => "test_preffix",
        ], $this->router->data);

        $router->backendGroup(['middleware' => 'backend'], function() {});

        $this->assertEquals([
            "middleware" => ["backend"],
            "prefix" => "test_preffix",
        ], $this->router->data);

        $router->backendGroup(['middleware' => ['backend']], function() {});

        $this->assertEquals([
            "middleware" => ["backend"],
            "prefix" => "test_preffix",
        ], $this->router->data);

        $router->backendGroup(['middleware' => ['test']], function() {});

        $this->assertEquals([
            "middleware" => ['test', "backend"],
            "prefix" => "test_preffix",
        ], $this->router->data);

        $router->backendGroup(['prefix' => 'test'], function() {});

        $this->assertEquals([
            "middleware" => 'backend',
            "prefix" => "test_preffix/test",
        ], $this->router->data);

        $router->backendGroup(['prefix' => '/test'], function() {});

        $this->assertEquals([
            "middleware" => 'backend',
            "prefix" => "test_preffix/test",
        ], $this->router->data);
    }
}

class TestRouterRouterTest implements Illuminate\Contracts\Routing\Registrar {

    public $data = [];
    public function get($uri, $action) {}
    public function post($uri, $action) {}
    public function put($uri, $action) {}
    public function delete($uri, $action) {}
    public function patch($uri, $action) {}
    public function options($uri, $action) {}
    public function match($methods, $uri, $action) {}

    public function resource($name, $controller, array $options = []) {}
    public function group(array $attributes, Closure $callback)
    {
        $this->data = $attributes;
    }

    public function substituteBindings($route) {}
    public function substituteImplicitBindings($route) {}
}