<?php

$router->group(['middleware' => 'backend.auth:backend'], function($router) {

    $router->get('me', 'UserController@me');
    $router->get('user/{id}', 'UserController@show');
    $router->get('users', 'UserController@index');

});