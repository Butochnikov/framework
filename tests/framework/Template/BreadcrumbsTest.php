<?php

use Mockery as m;

class BreadcrumbsTest extends TestCase
{
    /**
     * @param Closure $closure
     *
     * @return \SleepingOwl\Framework\Template\Breadcrumbs
     */
    protected function getBreadcrumbs(Closure $closure = null)
    {
        $breadcrumbs = new \SleepingOwl\Framework\Template\Breadcrumbs(
            $route = m::mock(\DaveJamesMiller\Breadcrumbs\CurrentRoute::class),
            $generator = m::mock(\DaveJamesMiller\Breadcrumbs\Generator::class),
            $theme = m::mock(\SleepingOwl\Framework\Contracts\Themes\Theme::class)
        );

        $generator->shouldReceive('generate')->once()->with(['test' => 'callback'], 'test', [])->andReturn([
            'key' => 'value',
        ]);

        $theme->shouldReceive('view')->once()
            ->with('layouts.partials.breadcrumbs', ['breadcrumbs' => ['key' => 'value']])
            ->andReturn($view = m::mock(\Illuminate\Contracts\View\View::class));

        $view->shouldReceive('render')->once()->andReturn('breadcrumbs data');

        if (is_callable($closure)) {
            $closure($route, $generator, $theme);
        }

        $breadcrumbs->register('test', 'callback');

        return $breadcrumbs;
    }

    public function testRenderWithName()
    {
        $breadcrumbs = $this->getBreadcrumbs();
        $return = $breadcrumbs->render('test');

        $this->assertEquals('breadcrumbs data', $return);
    }

    public function testRenderWithoutName()
    {
        $breadcrumbs = $this->getBreadcrumbs(function($route) {
            $route->shouldReceive('get')->once()->andReturn(['test', []]);
        });

        $return = $breadcrumbs->render();
        $this->assertEquals('breadcrumbs data', $return);
    }

    public function testRenderIfExistsWithName()
    {
        $breadcrumbs = $this->getBreadcrumbs(function($route) {
            $route->shouldNotReceive('get');
        });

        $this->assertEquals('breadcrumbs data', $breadcrumbs->renderIfExists('test'));
    }

    public function testRenderIfExistsWithoutName()
    {
        $breadcrumbs = $this->getBreadcrumbs(function($route) {
            $route->shouldReceive('get')->once()->andReturn(['test', []]);
        });

        $this->assertEquals('breadcrumbs data', $breadcrumbs->renderIfExists());
    }

    public function testRenderArray()
    {
        $breadcrumbs = $this->getBreadcrumbs(function($route, $generator) {
            $route->shouldNotReceive('get');
            $generator->shouldNotReceive('generate');
        });

        $this->assertEquals('breadcrumbs data', $breadcrumbs->renderArray('test'));
    }

    public function testRenderIfExistsArray()
    {
        $breadcrumbs = $this->getBreadcrumbs(function($route, $generator) {
            $route->shouldNotReceive('get');
            $generator->shouldNotReceive('generate');
        });

        $this->assertEquals('breadcrumbs data', $breadcrumbs->renderIfExistsArray('test'));
    }
}