<?php
namespace SleepingOwl\Api\Http\Controllers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Pagination\AbstractPaginator;
use Illuminate\Support\Collection;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;
use League\Fractal\Resource\Collection as ResourceCollection;
use League\Fractal\Resource\Item as ResourceItem;
use League\Fractal\Resource\ResourceAbstract;
use SleepingOwl\Api\Contracts\Manager;
use SleepingOwl\Api\Transformer;
use SleepingOwl\Framework\Http\Controllers\Controller as BaseController;

abstract class Controller extends BaseController
{
    /**
     * @var Manager
     */
    protected $manager;

    /**
     * @param Manager $manager
     */
    public function __construct(Manager $manager)
    {
        $this->manager = $manager;
    }

    /**
     * @param Model $item
     * @param Transformer $transformer
     *
     * @return JsonResponse
     */
    public function responseItem($item, Transformer $transformer): JsonResponse
    {
        return $this->response(
            new ResourceItem($item, $transformer)
        );
    }

    /**
     * @param Collection $collection
     * @param Transformer $transformer
     *
     * @return JsonResponse
     */
    public function responseCollection(Collection $collection, Transformer $transformer): JsonResponse
    {
        return $this->response(
            new ResourceCollection($collection, $transformer)
        );
    }

    /**
     * @param AbstractPaginator $paginator
     * @param Transformer $transformer
     * @param array $queryParams
     *
     * @return JsonResponse
     */
    public function responsePagination(AbstractPaginator $paginator, Transformer $transformer, array $queryParams = []): JsonResponse
    {
        $collection = $paginator->getCollection();
        $resource = new ResourceCollection($collection, $transformer);

        $paginator->appends($queryParams);
        $resource->setPaginator(
            new IlluminatePaginatorAdapter($paginator)
        );

        return $this->response(
            $resource
        );
    }

    /**
     * @param ResourceAbstract $resource
     *
     * @return JsonResponse
     */
    public function response(ResourceAbstract $resource): JsonResponse
    {
        return new JsonResponse(
            $this->manager->createData($resource)->toArray()
        );
    }
}