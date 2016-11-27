<?php
namespace SleepingOwl\Framework\Contracts;

interface SleepingOwl
{
    /**
     * Get the version number of the framework.
     *
     * @return string
     */
    public function version(): string;

    /**
     * Get the base path of the SleepingOwl installation.
     *
     * @return string
     */
    public function basePath(): string;

    /**
     * Set the base path for the SleepingOwl framework.
     *
     * @param  string  $basePath
     * @return $this
     */
    public function setBasePath(string $basePath);
}