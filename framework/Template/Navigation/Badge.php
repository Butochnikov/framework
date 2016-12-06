<?php
namespace SleepingOwl\Framework\Template\Navigation;

use KodiComponents\Navigation\Badge as BaseBadge;

class Badge extends BaseBadge
{
    /**
     * @param string|null $view
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function render($view = null)
    {
        return parent::render(theme()->viewPath('partials.navigation.badge'));
    }
}
