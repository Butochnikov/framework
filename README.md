![SleepingOwl framework](https://cloud.githubusercontent.com/assets/773481/20789977/796b108a-b7c7-11e6-9bf1-0db38be55f21.png)

[![Build Status](https://travis-ci.org/SleepingOwlAdmin/framework.svg?branch=master)](https://travis-ci.org/SleepingOwlAdmin/framework)
[![Latest Stable Version](https://poser.pugx.org/sleeping-owl/admin/v/unstable.svg)](https://packagist.org/packages/laravelrus/sleepingowl)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/SleepingOwlAdmin/framework/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/SleepingOwlAdmin/framework/?branch=master)

# SleepingOwl Framework built on Laravel

## Установка

1. `composer require sleepingowl/framework`
2. Добавить `SleepingOwl\Framework\Providers\FrameworkServiceProvider::class` в сервис провайдеры
3. Добавить `require __DIR__.'/../vendor/sleepingowl/framework/bootstrap/app.php';` в `public/index.php`
4. Добавить `require __DIR__.'/../vendor/sleepingowl/framework/bootstrap/app.php';` в `artisan`
5. Выполнить команду `php artisan sleepingowl:install`
