<?php
namespace SleepingOwl\Api\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use SleepingOwl\Api\Contracts\Manager;
use SleepingOwl\Api\Transformers\UserMeta as UserMetaTransformer;
use SleepingOwl\Framework\Contracts\Repositories\UserMetaRepository as UserMetaRepositoryContract;
use SleepingOwl\Framework\Entities\User;
use SleepingOwl\Framework\Entities\UserMeta;

class UserMetaController extends Controller
{
    /**
     * @var UserMetaRepositoryContract
     */
    private $repository;

    /**
     * UserMetaController constructor.
     *
     * @param Manager $manager
     * @param UserMetaRepositoryContract $repository
     */
    public function __construct(Manager $manager, UserMetaRepositoryContract $repository)
    {
        parent::__construct($manager);

        $this->repository = $repository;
    }

    /**
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function get(Request $request)
    {
        $this->validate($request, [
            'key' => 'required|string'
        ]);

        $meta = $this->repository->getByKey(
            $request->user()->id,
            $request->input('key')
        );

        return $this->responseItem(
            $meta,
            new UserMetaTransformer()
        );
    }

    /**
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'key' => 'required|string',
            'data' => 'required|array'
        ]);

        $meta = $this->repository->store(
            $request->user()->id,
            $request->input('key'),
            $request->input('data')
        );

        return $this->responseItem(
            $meta,
            new UserMetaTransformer()
        );
    }

    /**
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function delete(Request $request)
    {
        $this->validate($request, [
            'key' => 'required|string'
        ]);

        $status = $this->repository->delete(
            $request->user()->id,
            $request->input('key')
        );

        return new JsonResponse([
            'status' => $status
        ]);
    }
}