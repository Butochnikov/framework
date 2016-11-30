<?php

$router->get('framework/scripts', 'AppController@settings');

$router->backendGroup([], function ($router) {
    Auth::routes();

    $router->group(['middleware' => 'backend.auth:backend'], function($router) {
        $router->get('/', function(\Illuminate\Http\Request $request) {
            return themeView('layouts.backend', [
                'title' => 'Test title'
            ]);
        });
    });
});