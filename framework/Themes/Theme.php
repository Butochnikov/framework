<?php
namespace SleepingOwl\Framework\Themes;

use Illuminate\Config\Repository;
use Illuminate\Contracts\Config\Repository as ConfigContract;
use Illuminate\Contracts\View\Factory as ViewFactory;
use Illuminate\Contracts\View\View as ViewContract;
use SleepingOwl\Framework\Contracts\SleepingOwl;
use SleepingOwl\Framework\Contracts\Template\Meta as MetaContract;
use SleepingOwl\Framework\Contracts\Template\Navigation as NavigationContract;
use SleepingOwl\Framework\Contracts\Themes\Theme as ThemeContract;
use SleepingOwl\Framework\Routing\UrlGenerator;

abstract class Theme implements ThemeContract
{

    /**
     * @var SleepingOwl
     */
    protected $framework;

    /**
     * @var ViewFactory
     */
    protected $view;

    /**
     * @var ConfigContract
     */
    protected $config;

    /**
     * @var MetaContract
     */
    protected $meta;

    /**
     * @var NavigationContract
     */
    protected $navigation;

    /**
     * @param SleepingOwl $framework
     * @param MetaContract $meta
     * @param NavigationContract $navigation
     * @param ViewFactory $factory
     * @param array $config
     */
    public function __construct(
        SleepingOwl $framework,
        MetaContract $meta,
        NavigationContract $navigation,
        ViewFactory $factory,
        array $config = null
    )
    {
        $this->framework = $framework;
        $this->view = $factory;
        $this->meta = $meta;
        $this->navigation = $navigation;
        $this->config = new Repository($config);
    }

    /**
     * Настройки темы
     *
     * @return ConfigContract
     */
    public function getConfig(): ConfigContract
    {
        return $this->config;
    }

    /**
     * Генерация заголовка
     *
     * @param string|null $title
     *
     * @return string
     */
    public function title(string $title = null): string
    {
        return ! empty($title) ? $title.' | '.$this->framework->name() : $this->framework->name();
    }

    /**
     * Генерация относительно пути до asset файлов для текущей темы
     *
     * @param string $path относительный путь до файла, например `js/app.js`
     *
     * @return string
     */
    public function assetPath(string $path = null): string
    {
        return ! is_null($path) ? $this->assetDir().'/'.ltrim($path, '/') : $this->assetDir();
    }

    /**
     * Генерация абсолютного пути до asset файлов для текущей темы
     *
     * @param string $path относительный путь до файла, например `js/app.js`
     * @param bool|null $secure
     *
     * @return string
     */
    public function asset(string $path, bool $secure = null): string
    {
        return backend_url()->asset($path, $secure);
    }

    /**
     * Генерация пути до view для текущей темы с учетом namespace
     *
     * @param string|ViewContract $view Если передан ViewContract, то будет возвращен его путь
     *
     * @return string
     */
    public function viewPath($view): string
    {
        if ($view instanceof ViewContract) {
            return $view->getPath();
        }

        return $this->namespace().$view;
    }

    /**
     * @param string|ViewContract $view
     * @param array  $data
     * @param array  $mergeData
     *
     * @return \Illuminate\Contracts\View\Factory|ViewContract
     */
    public function view($view, $data = [], $mergeData = []): ViewContract
    {
        if ($view instanceof ViewContract) {
            return $view->with($data);
        }

        return $this->view->make($this->viewPath($view), $data, $mergeData);
    }

    /**
     * Генерация html meta
     *
     * @param string|null $title
     *
     * @return string
     */
    public function renderMeta(string $title = null): string
    {
        return $this->meta
            ->setFavicon($this->asset('favicon.ico'))
            ->setTitle($this->title($title))
            ->addMeta(['charset' => 'utf-8'], 'meta::charset')
            ->addMeta(['content' => csrf_token(), 'name' => 'csrf-token'])
            ->addMeta(['content' => 'width=device-width, initial-scale=1', 'name' => 'viewport'])
            ->addMeta(['content' => 'IE=edge', 'http-equiv' => 'X-UA-Compatible'])
            ->addJs(MetaContract::FRAMEWORK_SCRIPTS, asset('framework/scripts'))
            ->render();
    }

    /**
     * Генерация HTML кода навигации
     *
     * @return string
     */
    public function renderNavigation(): string
    {
        return $this->navigation->render(
            $this->viewPath('layouts.partials.navigation')
        );
    }
}