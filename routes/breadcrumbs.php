<?php

use DaveJamesMiller\Breadcrumbs\Generator;

$breadcrumbs->register('dashboard', function (Generator $breadcrumbs) {
    $breadcrumbs->push('Dashboard', route('backend.dashboard'));
});