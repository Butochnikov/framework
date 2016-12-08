![SleepingOwl framework](https://cloud.githubusercontent.com/assets/773481/20789977/796b108a-b7c7-11e6-9bf1-0db38be55f21.png)

[![Build Status](https://travis-ci.org/SleepingOwlAdmin/framework.svg?branch=master)](https://travis-ci.org/SleepingOwlAdmin/framework)
[![Latest Stable Version](https://poser.pugx.org/sleepingowl/framework/v/unstable.svg)](https://packagist.org/packages/sleepingowl/framework)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/SleepingOwlAdmin/framework/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/SleepingOwlAdmin/framework/?branch=master)

# SleepingOwl Framework built on Laravel

### Requirements
The minimum requirement by Framework is that your Web server supports PHP 7.0.

### Documentation
See https://github.com/SleepingOwlAdmin/framework/wiki

### Installation
1. Run `composer require sleepingowl/framework`
2. Add ServiceProvider `SleepingOwl\Framework\Providers\FrameworkServiceProvider::class` to `config/app.php`
3. Add `require __DIR__.'/../vendor/sleepingowl/framework/bootstrap/app.php';` to `public/index.php`
4. Add `require __DIR__.'/vendor/sleepingowl/framework/bootstrap/app.php';` to `artisan`
5. Run `php artisan sleepingowl:install`
