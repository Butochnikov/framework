<?php namespace SleepingOwl\Framework\Contracts\Repositories;

interface DashboardRepository
{
    /**
     * @param int $userId
     *
     * @return array
     */
    public function getWidgets(int $userId): array;

    /**
     * @param int $userId
     * @param array $widgets
     *
     * @return bool
     */
    public function updateWidgets(int $userId, array $widgets): bool;
}