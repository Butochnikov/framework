<?php

$router->get('framework/scripts', 'AppController@settings');

$router->backendGroup([], function ($router) {
    $router->get('/', function(\Illuminate\Http\Request $request) {
        return themeView('layouts.backend', [
            'title' => 'Test title',
            'route' => 'test'
        ]);
    });
});