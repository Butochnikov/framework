<?php

use DaveJamesMiller\Breadcrumbs\Generator;

$breadcrumbs->register('dashboard', function (Generator $breadcrumbs) {
    $breadcrumbs->push('Dashboard', route('dashboard'));
});

$breadcrumbs->register('filemanager', function (Generator $breadcrumbs) {
    $breadcrumbs->parent('dashboard');
    $breadcrumbs->push('Filemanager', route('filemanager'));
});