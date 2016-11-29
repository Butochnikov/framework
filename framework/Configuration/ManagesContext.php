<?php

namespace SleepingOwl\Framework\Configuration;

trait ManagesContext
{
    /**
     * Список установленных контекстов для текущего запроса
     *
     * @var array
     */
    protected $context = [];

    /**
     * Добавление контекста в текущий запрос
     *
     * @param string $context
     *
     * @return void
     */
    public function setContext(string $context)
    {
        if (! $this->context($context)) {
            $this->context[] = $context;
        }
    }

    /**
     * Если не переданы аргументы - получение списка контекстов для текущего запроса
     * При передачи аргументов, то проверка на наличие контекста
     *
     * @return array|bool
     */
    public function context()
    {
        if (func_num_args() > 0) {
            $patterns = is_array(func_get_arg(0)) ? func_get_arg(0) : func_get_args();

            foreach ($patterns as $pattern) {
                if (in_array($pattern, $this->context)) {
                    return true;
                }
            }

            return false;
        }

        return $this->context;
    }
}
