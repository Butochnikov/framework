<?php
namespace SleepingOwl\Framework\Themes;

use InvalidArgumentException;
use SleepingOwl\Framework\Contracts\Themes\Factory as ThemeFactory;
use SleepingOwl\Framework\Contracts\Themes\Theme as ThemeContract;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ThemesManager implements ThemeFactory
{

    /**
     * The application instance.
     *
     * @var \Illuminate\Contracts\Foundation\Application
     */
    protected $app;

    /**
     * Список доступных тем
     *
     * @var array
     */
    protected $themes = [];

    /**
     * @var OptionsResolver
     */
    protected $resolver;

    /**
     * @param \Illuminate\Contracts\Foundation\Application $app
     */
    public function __construct(\Illuminate\Contracts\Foundation\Application $app)
    {
        $this->app = $app;
        $this->resolver = new OptionsResolver();

        $this->configureOptions($this->resolver);
    }

    /**
     * Получение объекта текущей темы
     *
     * @return ThemeContract
     */
    public function theme(): ThemeContract
    {
        $name = $this->getDefaultTheme();

        return $this->themes[$name] = $this->get($name);
    }

    /**
     * @param string $name
     *
     * @return ThemeContract
     */
    protected function get(string $name): ThemeContract
    {
        return isset($this->themes[$name]) ? $this->themes[$name] : $this->resolve($name);
    }

    /**
     * Получение ключа темы по умолчанию
     *
     * @return string
     */
    public function getDefaultTheme(): string
    {
        return $this->app['config']['sleepingowl.theme.default'];
    }

    /**
     * Изменение темы по умолчанию
     *
     * @param  string $name
     *
     * @return void
     */
    public function setDefaultTheme(string $name)
    {
        $this->app['config']['sleepingowl.theme.default'] = $name;
    }

    /**
     * Получаение настроек для темы
     *
     * @param  string $name
     *
     * @return array
     */
    protected function getConfig($name)
    {
        return $this->app['config']["sleepingowl.theme.themes.{$name}"];
    }

    /**
     * Создание объекта из переданного класса
     *
     * @param string $name
     *
     * @return ThemeContract
     */
    protected function resolve(string $name): ThemeContract
    {
        $config = $this->getConfig($name);
        $config = $this->resolver->resolve($config);

        if (is_null($config)) {
            throw new InvalidArgumentException("Theme [{$name}] is not defined.");
        }

        $class = $config['class'];

        if (! class_exists($class)) {
            throw new InvalidArgumentException("Theme [{$name}] is not supported.");
        }

        return $this->app->make($class, ['config' => $config]);
    }

    /**
     * Настройка валидатора для конфига подключаемой темы
     *
     * @param OptionsResolver $resolver
     *
     * @return void
     */
    protected function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setRequired('class');
        $resolver->setAllowedTypes('class', 'string');
    }

    /**
     * @param  string $method
     * @param  array $parameters
     *
     * @return mixed
     */
    public function __call($method, $parameters)
    {
        return $this->theme()->$method(...$parameters);
    }
}