<?php

$router->group(['middleware' => 'backend.auth:backend'], function($router) {

    $router->get('me', 'UserController@me');
    $router->get('user/{id}', 'UserController@show');
    $router->get('users', 'UserController@index');


    $router->get('filemanager', 'FilemanagerController@listFiles');
    $router->get('filemanager/download', 'FilemanagerController@download');
    $router->post('filemanager', 'FilemanagerController@upload');
    $router->post('filemanager/mkdir', 'FilemanagerController@makeDirectory');
    $router->delete('filemanager', 'FilemanagerController@delete');
    $router->delete('filemanager/dir', 'FilemanagerController@deleteDirectory');
});