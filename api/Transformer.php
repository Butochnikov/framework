<?php
namespace SleepingOwl\Api;

use League\Fractal\TransformerAbstract;
use SleepingOwl\Api\Contracts\Transformer as TransformerContract;

abstract class Transformer extends TransformerAbstract implements TransformerContract
{

}