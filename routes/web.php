<?php

$router->backendGroup([], function ($router) {
    $router->auth();

    $router->group(['middleware' => 'backend.auth:backend'], function($router) {
        $router->get('/', function(\Illuminate\Http\Request $request) {
            return themeView('dashboard', [
                'title' => 'Dashboard',
                'breadcrumbs' => $this->app[\SleepingOwl\Framework\Contracts\Template\Breadcrumbs::class]->renderIfExists()
            ]);
        })->name('dashboard');

        $router->get('filemanager', function(\Illuminate\Http\Request $request) {
            return themeView('filemanager.index', [
                'title' => 'File manager',
                'breadcrumbs' => $this->app[\SleepingOwl\Framework\Contracts\Template\Breadcrumbs::class]->renderIfExists()
            ]);
        })->name('filemanager');
    });
});