<?php

namespace SleepingOwl\Framework\Template\Navigation;

use KodiComponents\Navigation\Page as BasePage;

class Page extends BasePage
{
    /**
     * @param string|null $view
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function render($view = null)
    {
        return parent::render(theme()->viewPath('layouts.partials.navigation.page'));
    }
}
