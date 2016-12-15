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
use SleepingOwl\Api\Contracts\Transformer as TransformerContract;
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
     * @param TransformerContract $transformer
     * @param string|null $type
     *
     * @return JsonResponse
     */
    public function responseItem($item, TransformerContract $transformer, string $type = null): JsonResponse
    {
        if (is_null($type)) {
            $type = $transformer->type();
        }

        return $this->response(
            new ResourceItem($item, $transformer, $type)
        );
    }

    /**
     * @param Collection $collection
     * @param TransformerContract $transformer
     * @param string|null $type
     *
     * @return JsonResponse
     */
    public function responseCollection(Collection $collection, TransformerContract $transformer, string $type = null): JsonResponse
    {
        if (is_null($type)) {
            $type = $transformer->type();
        }

        return $this->response(
            new ResourceCollection($collection, $transformer, $type)
        );
    }

    /**
     * @param AbstractPaginator $paginator
     * @param TransformerContract $transformer
     * @param array $queryParams
     * @param string|null $type
     *
     * @return JsonResponse
     */
    public function responsePagination(AbstractPaginator $paginator, TransformerContract $transformer, array $queryParams = [], string $type = null): JsonResponse
    {
        if (is_null($type)) {
            $type = $transformer->type();
        }

        $collection = $paginator->getCollection();
        $resource = new ResourceCollection($collection, $transformer, $type);

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