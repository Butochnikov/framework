<?php
namespace SleepingOwl\Framework\Contracts\Template;

use KodiComponents\Navigation\Contracts\NavigationInterface;

interface Navigation extends NavigationInterface
{
    /**
     * @param Breadcrumbs $breadcrumbs
     */
    public function buildBreadcrumbs(Breadcrumbs $breadcrumbs);
}