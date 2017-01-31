<?php

$router->group(['middleware' => 'backend.auth:backend'], function($router) {

    $router->get('dashboard', 'DashboardController@index');
    $router->post('dashboard', 'DashboardController@updateWidgets');

    $router->get('me/meta', 'UserMetaController@get');
    $router->post('me/meta', 'UserMetaController@store');
    $router->delete('me/meta', 'UserMetaController@delete');

    $router->get('me', 'UserController@me');

    $router->get('user/{id}', 'UserController@show');
    $router->get('users', 'UserController@index');

    $router->get('filemanager', 'FileManagerController@listFiles');
    $router->get('filemanager/download', 'FileManagerController@download');
    $router->post('filemanager', 'FileManagerController@upload');
    $router->post('filemanager/mkdir', 'FileManagerController@makeDirectory');
    $router->delete('filemanager', 'FileManagerController@delete');
    $router->delete('filemanager/dir', 'FileManagerController@deleteDirectory');
});