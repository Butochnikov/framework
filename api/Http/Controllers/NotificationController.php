<?php
namespace SleepingOwl\Api\Http\Controllers;

use Illuminate\Http\JsonResponse;
use SleepingOwl\Api\Contracts\Manager;
use SleepingOwl\Api\Transformers\Notification as NotificationTransformer;
use Illuminate\Http\Request;
use SleepingOwl\Framework\Contracts\Repositories\NotificationsRepository as NotificationsRepositoryContract;

class NotificationController extends Controller
{
    /**
     * @var NotificationsRepositoryContract
     */
    private $repository;

    /**
     * @param Manager $manager
     * @param NotificationsRepositoryContract $repository
     */
    public function __construct(Manager $manager, NotificationsRepositoryContract $repository)
    {
        parent::__construct($manager);

        $this->repository = $repository;
    }

    /**
     * Get the recent notifications and announcements for the user.
     *
     * @param Request $request
     * @param string $id
     *
     * @return JsonResponse
     */
    public function get(Request $request, string $id): JsonResponse
    {
        return $this->responseItem(
            $this->repository->getById($request->user(), $id),
            new NotificationTransformer()
        );
    }

    /**
     * Get the recent notifications and announcements for the user.
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function recent(Request $request): JsonResponse
    {
        return $this->responseCollection(
            $this->repository->recent($request->user()),
            new NotificationTransformer()
        );
    }

    /**
     * Mark the given notifications as read.
     *
     * @param Request $request
     */
    public function markAsRead(Request $request)
    {
        $this->validate($request, [
            'ids' => 'array',
        ]);

        $this->repository->markAsRead($request->user(), $request->input('ids', []));
    }
}