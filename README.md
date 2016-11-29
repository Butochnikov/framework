# SleepingOwl Framework built on Laravel

## Установка

1. Добавить `SleepingOwl\Framework\Providers\FrameworkServiceProvider::class` в сервис провайдеры
2. Добавить `require __DIR__.'/../vendor/sleepingowl/framework/bootstrap/app.php';` в `public/index.php`
3. Выполнить команду `php artisan vendor:publish --tag=sleepingowl-asset --force`