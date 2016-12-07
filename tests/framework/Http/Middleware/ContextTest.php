<?php

use Mockery as m;
use SleepingOwl\Framework\Contracts\SleepingOwl;
use SleepingOwl\Framework\Http\Middleware\Context;

class ContextTest extends TestCase
{

    public function testConstructor()
    {
        $router = $this->getRouter();
        $router->shouldReceive('getUrlPrefix')->once()->andReturn('test_prefix');

        new Context(
            $this->getFramework(), $router
        );
    }

    public function testGettingContext()
    {
        $router = $this->getRouter();
        $router->shouldReceive('getUrlPrefix')->once()->andReturn('test_prefix');

        $context = new Context(
            $framework = $this->getFramework(), $router
        );

        $context->handle($this->getRequest(), function() {

        });

        $this->assertTrue($framework->context(SleepingOwl::CTX_FRONTEND));
        $this->assertFalse($framework->context(SleepingOwl::CTX_BACKEND));
    }

    public function testGettingBackendContext()
    {
        $router = $this->getRouter();
        $router->shouldReceive('getUrlPrefix')->once();

        $context = new Context(
            $framework = $this->getFramework(), $router
        );

        $context->handle($this->getRequest(), function() {

        }, 'backend');

        $this->assertTrue($framework->context(SleepingOwl::CTX_BACKEND));
        $this->assertFalse($framework->context(SleepingOwl::CTX_FRONTEND));
    }

    public function testGettingBackendContextFromRequest()
    {
        $router = $this->getRouter();
        $router->shouldReceive('getUrlPrefix')->once()->andReturn('test_prefix');

        $context = new Context(
            $framework = $this->getFramework(), $router
        );

        $context->handle($this->getRequest('http://site.com/test_prefix'), function() {});
        $this->assertTrue($framework->context(SleepingOwl::CTX_BACKEND));
        $this->assertFalse($framework->context(SleepingOwl::CTX_FRONTEND));
    }

    public function testGettingBackendContextFromInnerRequest()
    {
        $router = $this->getRouter();
        $router->shouldReceive('getUrlPrefix')->once()->andReturn('test_prefix');

        $context = new Context(
            $framework = $this->getFramework(), $router
        );

        $context->handle($this->getRequest('http://site.com/test_prefix/inner'), function() {});
        $this->assertTrue($framework->context(SleepingOwl::CTX_BACKEND));
        $this->assertFalse($framework->context(SleepingOwl::CTX_FRONTEND));
    }

    public function testGettingApiContext()
    {
        $router = $this->getRouter();
        $router->shouldReceive('getUrlPrefix')->once()->andReturn('test_prefix');

        $context = new Context(
            $framework = $this->getFramework(), $router
        );

        $context->handle($this->getRequest('http://site.com/test_prefix/inner'), function() {}, SleepingOwl::CTX_API);
        $this->assertTrue($framework->context(SleepingOwl::CTX_API));
    }

    public function testGettingCustomContext()
    {
        $router = $this->getRouter();
        $router->shouldReceive('getUrlPrefix')->once()->andReturn('test_prefix');

        $context = new Context(
            $framework = $this->getFramework(), $router
        );

        $context->handle($this->getRequest('http://site.com/test_prefix/inner'), function() {}, 'api|backend|custom');
        $this->assertTrue($framework->context(SleepingOwl::CTX_API));
        $this->assertTrue($framework->context(SleepingOwl::CTX_BACKEND));
        $this->assertTrue($framework->context('custom'));
    }
}