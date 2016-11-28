<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Backend URL prefix
    |--------------------------------------------------------------------------
    */

    'url_prefix' => 'backend',

    /*
    |--------------------------------------------------------------------------
    |  Admin panel theme
    |--------------------------------------------------------------------------
    */
    'theme' => [
        'default' => env('SLEEPINGOWL_THEME', 'admin-lte'),

        'themes' => [
            'admin-lte' => [
                'class' => \SleepingOwl\Framework\Themes\AdminLteTheme::class
            ]
        ]
    ],
];