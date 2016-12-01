<?php
namespace SleepingOwl\Api\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use SleepingOwl\Api\Transformers\User as UserTransformer;
use SleepingOwl\Framework\Entities\User;

class UserController extends Controller
{
    /**
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function me(Request $request)
    {
        return $this->responseItem(
            $request->user(),
            new UserTransformer()
        );
    }

    /**
     * @return JsonResponse
     */
    public function index()
    {
        return $this->responsePagination(
            User::paginate(),
            new UserTransformer()
        );
    }

    /**
     * @param integer $id
     *
     * @return JsonResponse
     */
    public function show($id)
    {
        return $this->responseItem(
            User::findOrFail($id),
            new UserTransformer()
        );
    }
}