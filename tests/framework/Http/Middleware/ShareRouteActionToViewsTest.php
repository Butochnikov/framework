<?php

use Mockery as m;
use SleepingOwl\Framework\Http\Middleware\ShareRouteActionToViews;

class ShareRouteActionToViewsTest extends TestCase
{
    public function testHandle()
    {
        $request = m::mock($this->getRequest());
        $request->shouldReceive('route')->andReturnUsing(function() {
            $router = m::mock(\Illuminate\Routing\Route::class);
            $router->shouldReceive('getActionName')->once()->andReturn('test_route');

            return $router;
        });

        $middleware = new ShareRouteActionToViews(
            $view = m::mock(\Illuminate\Contracts\View\Factory::class)
        );

        $view->shouldReceive('share')->once()->with('routeAction', 'test_route');


        $middleware->handle($request, function (){});
    }
}