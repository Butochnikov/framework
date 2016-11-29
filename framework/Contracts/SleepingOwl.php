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
     * Get the version number of the framework.
     *
     * @return string
     */
    public function version(): string;

    /**
     * Get the name of the framework.
     *
     * @return string
     */
    public function name(): string;

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
}