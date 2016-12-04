<?php

$router->backendGroup([], function ($router) {
    $router->get('framework/scripts', 'AppController@settings');

    Auth::routes();

    $router->group(['middleware' => 'backend.auth:backend'], function($router) {
        $router->get('/', function(\Illuminate\Http\Request $request) {
            return themeView('filemanager.index', [
                'title' => 'File manager'
            ]);
        });
    });
});