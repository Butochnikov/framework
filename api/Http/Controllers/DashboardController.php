<?php
namespace SleepingOwl\Api\Http\Controllers;

use Illuminate\Http\JsonResponse;
use SleepingOwl\Api\Contracts\Manager;
use Illuminate\Http\Request;
use SleepingOwl\Framework\Contracts\Repositories\DashboardRepository as DashboardRepositoryContract;

class DashboardController extends Controller
{
    /**
     * @var DashboardRepositoryContract
     */
    private $repository;

    /**
     * @param Manager $manager
     * @param DashboardRepositoryContract $repository
     */
    public function __construct(Manager $manager, DashboardRepositoryContract $repository)
    {
        parent::__construct($manager);

        $this->repository = $repository;
    }

    /**
     * Вывод списка виджетов
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $widgets = $this->repository->getWidgets(
            $request->user()->id
        );

        return new JsonResponse([
            'widgets' => $widgets
        ]);
    }

    /**
     * Обновление расположения виджетов
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function updateWidgets(Request $request): JsonResponse
    {
        $this->validate($request, [
            'widgets' => 'required|array'
        ]);


        $this->repository->updateWidgets(
            $request->user()->id,
            $request->input('widgets', [])
        );

        return new JsonResponse([
            'status' => true
        ]);
    }
}