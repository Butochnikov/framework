[![Build Status](https://travis-ci.org/SleepingOwlAdmin/framework.svg?branch=master)](https://travis-ci.org/SleepingOwlAdmin/framework)
[![Latest Stable Version](https://poser.pugx.org/sleeping-owl/admin/v/unstable.svg)](https://packagist.org/packages/laravelrus/sleepingowl)

# SleepingOwl Framework built on Laravel

## Установка

1. `composer require sleepingowl/framework`
2. Добавить `SleepingOwl\Framework\Providers\FrameworkServiceProvider::class` в сервис провайдеры
3. Добавить `require __DIR__.'/../vendor/sleepingowl/framework/bootstrap/app.php';` в `public/index.php`
4. Выполнить команду `php artisan vendor:publish --tag=sleepingowl-asset --force`
