<?php
namespace SleepingOwl\Api\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use SleepingOwl\Api\Transformers\UserMeta as UserMetaTransformer;
use SleepingOwl\Framework\Entities\User;
use SleepingOwl\Framework\Entities\UserMeta;

class UserMetaController extends Controller
{
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

        /** @var UserMeta $meta */
        $meta = $request->user()->meta()
            ->where('key', $request->input('key'))
            ->firstOrFail();

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
    public function create(Request $request)
    {
        /** @var User $user */
        $user = $request->user();

        $this->validate($request, [
            'key' => 'required|string',
            'data' => 'required|array'
        ]);

        /** @var UserMeta $meta */
        $user->meta()->create([
            'key' => $request->input('key'),
            'data' => $request->input('data'),
        ]);

        return new JsonResponse([
            'status' => 'ok'
        ]);
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

        /** @var UserMeta $meta */
        $request->user()->meta()
            ->where('key', $request->input('key'))
            ->delete();

        return new JsonResponse([
            'status' => 'ok'
        ]);
    }
}