<?php
namespace SleepingOwl\Framework\Template;

use DaveJamesMiller\Breadcrumbs\Generator as BreadcrumbsGenerator;
use KodiComponents\Navigation\Navigation as BaseNavigation;
use KodiComponents\Navigation\PageCollection;
use SleepingOwl\Framework\Contracts\Template\Breadcrumbs as BreadcrumbsContract;
use SleepingOwl\Framework\Contracts\Template\Navigation as NavigationContract;

class Navigation extends BaseNavigation implements NavigationContract
{
    /**
     * @param BreadcrumbsContract $breadcrumbs
     */
    public function buildBreadcrumbs(BreadcrumbsContract $breadcrumbs)
    {
        $this->registerBreadcrumbsForPages(
            $breadcrumbs, $this->getPages()
        );
    }

    /**
     * @param BreadcrumbsContract $breadcrumbs
     * @param PageCollection $pages
     */
    protected function registerBreadcrumbsForPages(BreadcrumbsContract $breadcrumbs, PageCollection $pages)
    {
        foreach ($pages as $page) {
            $breadcrumbs->register($page->getId(), function (BreadcrumbsGenerator $breadcrumbs) use ($page) {
                $breadcrumbs->parent(
                    $page->isChild() ? $page->getParent()->getId() : 'dashboard'
                );

                $breadcrumbs->push($page->getTitle(), $page->getUrl());
            });

            if ($page->hasChild()) {
                $this->registerBreadcrumbsForPages(
                    $breadcrumbs, $page->getPages()
                );
            }
        }
    }
}