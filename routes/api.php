<?php

$router->group(['middleware' => 'backend.auth:backend'], function($api) {

    $api->get('notifications', 'NotificationController@recent');
    $api->get('notification/{id}', 'NotificationController@get');
    $api->put('notifications/read', 'NotificationController@markAsRead');

    $api->get('me/meta', 'UserMetaController@get');
    $api->post('me/meta', 'UserMetaController@store');
    $api->delete('me/meta', 'UserMetaController@delete');

    $api->get('me', 'UserController@me');

    $api->get('user/{id}', 'UserController@show');
    $api->get('users', 'UserController@index');

    $api->get('filemanager', 'FilemanagerController@listFiles');
    $api->get('filemanager/download', 'FilemanagerController@download');
    $api->post('filemanager', 'FilemanagerController@upload');
    $api->post('filemanager/mkdir', 'FilemanagerController@makeDirectory');
    $api->delete('filemanager', 'FilemanagerController@delete');
    $api->delete('filemanager/dir', 'FilemanagerController@deleteDirectory');
});