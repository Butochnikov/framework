<?php
namespace SleepingOwl\Framework\Events;

use SleepingOwl\Framework\Contracts\Themes\Theme;

class ThemeLoaded
{
    /**
     * @var Theme
     */
    public $theme;

    /**
     * @param Theme $theme
     */
    public function __construct(Theme $theme)
    {
        $this->theme = $theme;
    }
}