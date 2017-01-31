<?php
namespace SleepingOwl\Api\Http\Controllers;

use SleepingOwl\Api\ResponseHelpers;
use SleepingOwl\Framework\Http\Controllers\Controller as BaseController;

abstract class Controller extends BaseController
{
    use ResponseHelpers;
}