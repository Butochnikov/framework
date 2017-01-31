<?php
namespace SleepingOwl\Api\Contracts;

interface Transformer
{
    /**
     * @return string
     */
    public function type(): string;
}