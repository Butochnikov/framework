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
     * @param string|string[] ...$context
     *
     * @return void
     */
    public function setContext(string ...$context)
    {
        foreach ($context as $name) {
            if (! $this->context($name)) {
                $this->context[] = $name;
            }
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
            $context = is_array(func_get_arg(0)) ? func_get_arg(0) : func_get_args();

            foreach ($context as $name) {
                if (in_array($name, $this->context)) {
                    return true;
                }
            }

            return false;
        }

        return $this->context;
    }
}
