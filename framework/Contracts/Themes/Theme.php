<?php
namespace SleepingOwl\Framework\Contracts\Themes;

use Illuminate\Contracts\Config\Repository as ConfigContract;
use Illuminate\Contracts\View\View as ViewContract;
use SleepingOwl\Framework\Contracts\Template\Meta;
use SleepingOwl\Framework\Contracts\Template\Navigation;

interface Theme
{

    /**
     * Название темы
     *
     * @return string
     */
    public function name() : string;

    /**
     * Получение HTML кода логотипа
     *
     * @return string
     */
    public function logo() : string;

    /**
     * Получение HTML кода компактной версии логотипа
     *
     * @return string
     */
    public function logoSmall() : string;

    /**
     * Настройки темы
     *
     * @return ConfigContract
     */
    public function getConfig(): ConfigContract;

    /**
     * Генерация заголовка
     *
     * @param string|null $title
     *
     * @return string
     */
    public function title(string $title = null) : string;

    /**
     * Генерация относительно пути до asset файлов для текущей темы
     *
     * @param string $path относительный путь до файла, например `js/app.js`
     *
     * @return string
     */
    public function assetPath(string $path = null) : string;

    /**
     * Получение относительного пути директории хранения asset файлов
     *
     * @return string
     */
    public function assetDir() : string;

    /**
     * Генерация абсолютного пути до asset файлов для текущей темы
     *
     * @param string $path относительный путь до файла, например `js/app.js`
     * @param bool|null $secure
     *
     * @return string
     */
    public function asset(string $path, bool $secure = null) : string;

    /**
     * Получение неймспейса для view шаблонов
     *
     * @return string
     */
    public function namespace() : string;

    /**
     * Генерация пути до view для текущей темы с учетом namespace
     *
     * @param string|ViewContract $view Если передан ViewContract, то будет возвращен его путь
     *
     * @return string
     */
    public function viewPath($view) : string;

    /**
     * @param string|ViewContract $view
     * @param array $data
     * @param array $mergeData
     *
     * @return \Illuminate\Contracts\View\Factory|ViewContract
     */
    public function view($view, $data = [], $mergeData = []) : ViewContract;

    /**
     * Генерация html meta
     *
     * @param string|null $title
     *
     * @return string
     */
    public function renderMeta(string $title = null): string;

    /**
     * Генерация HTML кода навигации
     *
     * @return string
     */
    public function renderNavigation(): string;
}