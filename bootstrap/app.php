<?php

/*
|--------------------------------------------------------------------------
| Bind SleepingOwl Framework Interfaces
|--------------------------------------------------------------------------
|
| Для более гибкой интеграции с приложением необходимо переопределенить
| стандартные интерфейсы
|
*/

$app->singleton(
    Illuminate\Contracts\Http\Kernel::class,
    SleepingOwl\Framework\Http\Kernel::class
);

$app->singleton(
    Illuminate\Contracts\Console\Kernel::class,
    SleepingOwl\Framework\Console\Kernel::class
);

$app->singleton(
    Illuminate\Contracts\Debug\ExceptionHandler::class,
    SleepingOwl\Framework\Exceptions\Handler::class
);