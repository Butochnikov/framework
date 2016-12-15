<?php
namespace SleepingOwl\Framework\Repositories;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use SleepingOwl\Framework\Contracts\Dashboard\Widget as WidgetContract;
use SleepingOwl\Framework\Contracts\Repositories\DashboardRepository as DashboardRepositoryContract;
use SleepingOwl\Framework\Contracts\Repositories\UserMetaRepository as UserMetaRepositoryContract;

class DashboardRepository implements DashboardRepositoryContract
{
    /**
     * @var UserMetaRepositoryContract
     */
    private $metaRepository;

    /**
     * @var Application
     */
    private $app;

    /**
     * @param Application $application
     * @param UserMetaRepositoryContract $metaRepository
     */
    public function __construct(Application $application, UserMetaRepositoryContract $metaRepository)
    {
        $this->metaRepository = $metaRepository;
        $this->app = $application;
    }

    /**
     * @param string $class
     * @param string $id
     * @param int $sizeX
     * @param int $sizeY
     *
     * @return WidgetContract
     */
    public function makeWidget(string $class, string $id, int $sizeX = null, int $sizeY = null): WidgetContract
    {
        return $this->app->make($class, [
            'id' => $id,
            'sizeX' => $sizeX,
            'sizeY' => $sizeY
        ]);
    }

    public function addWidget(string $class, int $userId, array $data)
    {

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