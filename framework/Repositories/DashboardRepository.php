<?php
namespace SleepingOwl\Framework\Repositories;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use SleepingOwl\Framework\Contracts\Repositories\DashboardRepository as DashboardRepositoryContract;
use SleepingOwl\Framework\Contracts\Repositories\UserMetaRepository as UserMetaRepositoryContract;

class DashboardRepository implements DashboardRepositoryContract
{
    /**
     * @var UserMetaRepositoryContract
     */
    private $metaRepository;

    /**
     * @param UserMetaRepositoryContract $metaRepository
     */
    public function __construct(UserMetaRepositoryContract $metaRepository)
    {
        $this->metaRepository = $metaRepository;
    }

    /**
     * @param int $userId
     *
     * @return array
     */
    public function getWidgets(int $userId): array
    {
        try {
            $meta = $this->metaRepository->getByKey(
                $userId,
                'dashboard'
            );

            return (array) $meta->data;
        } catch (ModelNotFoundException $exception) {
            return [];
        }
    }

    /**
     * @param int $userId
     * @param array $widgets
     *
     * @return bool
     */
    public function updateWidgets(int $userId, array $widgets): bool
    {
        $this->metaRepository->store(
            $userId,
            'dashboard',
            $widgets
        );

        return true;
    }
}