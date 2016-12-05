<?php
namespace SleepingOwl\Framework\Contracts;

use Illuminate\Config\Repository as ConfigRepository;

interface SleepingOwl
{
    /**
     * The SleepingOwl contexts.
     */
    const CTX_BACKEND = 'backend';
    const CTX_FRONTEND = 'frontend';
    const CTX_API = 'api';

    /**
     * Get the default JavaScript variables for Framework.
     *
     * @return array
     */
    public function scriptVariables(): array;

    /**
     * Получение версии фреймворка
     *
     * @return string
     */
    public function version(): string;

    /**
     * Получение название фреймворка
     *
     * @return string
     */
    public function name(): string;

    /**
     * Получение названия фреймворка с указанием версии
     *
     * @return string
     */
    public function longName(): string;

    /**
     * Получение настроек
     *
     * @return ConfigRepository
     */
    public function config(): ConfigRepository;

    /**
     * Get the base path of the SleepingOwl installation.
     *
     * @return string
     */
    public function basePath(): string;

    /**
     * Set the base path for the SleepingOwl framework.
     *
     * @param  string  $basePath
     * @return $this
     */
    public function setBasePath(string $basePath);

    /**
     * Добавление контекста в текущий запрос
     *
     * @param string|string[] ...$context
     *
     */
    public function setContext(string ...$context);

    /**
     * Если не переданы аргументы - получение списка контекстов для текущего запроса
     * При передачи аргументов, то проверка на наличие контекста
     *
     * @return bool|array
     */
    public function context();

    /**
     * URL префикс админ панели по умочанию
     *
     * @return string
     */
    public static function defaultUrlPrefix(): string;

    /**
     * URL префикс админ панели
     *
     * @return string
     */
    public function urlPrefix(): string;
}