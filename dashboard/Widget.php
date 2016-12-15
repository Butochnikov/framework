<?php
namespace SleepingOwl\Dashboard;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Contracts\View\Factory as ViewFactory;
use KodiComponents\Support\Contracts\Initializable;

abstract class Widget implements Renderable, Arrayable, Initializable
{
    /**
     * Виджет может быть добавлен несколько раз
     *
     * @var bool
     */
    protected $isMultiple = true;

    /**
     * Размер по горизонтали
     *
     * @var array
     */
    protected $sizeX = 1;

    /**
     * Размер по вертикали
     *
     * @var array
     */
    protected $sizeY = 1;

    /**
     * Максимальный размер виджета
     *
     * @var array
     */
    protected $maxSize = [1, 1];

    /**
     * Минимальный рамер виджета
     *
     * @var array
     */
    protected $minSize = [1, 1];

    /**
     * @var string
     */
    protected $view;

    /**
     * @var ViewFactory
     */
    protected $factory;

    /**
     * @var string
     */
    protected $id;

    /**
     * @param ViewFactory $factory
     * @param string $id
     * @param int $sizeX
     * @param int $sizeY
     */
    public function __construct(ViewFactory $factory, string $id, int $sizeX = null, int $sizeY = null)
    {
        $this->factory = $factory;
        $this->id = $id;

        if ($sizeX) {
            $this->sizeX = $sizeX;
        }

        if ($sizeY) {
            $this->sizeY = $sizeY;
        }
    }

    /**
     * @return bool
     */
    public function isMultiple(): bool
    {
        return $this->isMultiple;
    }

    /**
     * @return array
     */
    public function maxSize(): array
    {
        return $this->maxSize;
    }

    /**
     * @return array
     */
    public function minSize(): array
    {
        return $this->minSize;
    }

    /**
     * Get the evaluated contents of the object.
     *
     * @return string
     */
    public function render()
    {
        $this->factory->make($this->view, $this->toArray());
    }

    /**
     * Get the instance as an array.
     *
     * @return array
     */
    public function toArray()
    {
        return [
            'id' => $this->id,
            'maxSize' => $this->maxSize(),
            'minSize' => $this->minSize(),
            'multiple' => $this->isMultiple()
        ];
    }
}