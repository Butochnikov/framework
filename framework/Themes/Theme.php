<?php
namespace SleepingOwl\Framework\Themes;

use Illuminate\Contracts\Routing\UrlGenerator;
use Illuminate\Contracts\View\Factory as ViewFactory;
use Illuminate\Contracts\View\View as ViewContract;
use SleepingOwl\Framework\Contracts\SleepingOwl;
use SleepingOwl\Framework\Contracts\Themes\Theme as ThemeContract;

abstract class Theme implements ThemeContract
{

    /**
     * @var SleepingOwl
     */
    protected $framework;

    /**
     * @var UrlGenerator
     */
    protected $url;

    /**
     * @var ViewFactory
     */
    protected $view;

    /**
     * @var array
     */
    protected $config;

    /**
     * @param SleepingOwl $framework
     * @param UrlGenerator $generator
     * @param ViewFactory $factory
     * @param array $config
     */
    public function __construct(SleepingOwl $framework, UrlGenerator $generator, ViewFactory $factory, array $config = null)
    {
        $this->framework = $framework;
        $this->url = $generator;
        $this->view = $factory;
        $this->config = $config;
    }

    /**
     * Настройки темы
     *
     * @return array
     */
    public function getConfig(): array
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
        return $this->url->asset($this->assetPath($path), $secure);
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

        return $this->namespace().'::'.$this->name().'.'.$view;
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
}