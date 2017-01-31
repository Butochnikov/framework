<?php
namespace SleepingOwl\Api;

use Closure;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Pagination\AbstractPaginator;
use Illuminate\Support\Collection;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;
use League\Fractal\Resource\Collection as ResourceCollection;
use League\Fractal\Resource\Item as ResourceItem;
use League\Fractal\Resource\ResourceAbstract;
use League\Fractal\Scope;
use SleepingOwl\Api\Contracts\Manager;
use SleepingOwl\Api\Contracts\Transformer as TransformerContract;

trait ResponseHelpers
{

    /**
     * @return Manager
     */
    public function manager()
    {
        return app(Manager::class);
    }

    /**
     * Respond with a created response and associate a location if provided.
     *
     * @param string|null $location
     * @param null $content
     *
     * @return JsonResponse
     */
    public function created(string $location = null, $content = null): JsonResponse
    {
        $response = new JsonResponse($content, 201);

        if (! is_null($location)) {
            $response->header('Location', $location);
        }

        return $response;
    }

    /**
     * Respond with an accepted response and associate a location and/or content if provided.
     *
     * @param string|null $location
     * @param null $content
     *
     * @return JsonResponse
     */
    public function accepted(string $location = null, $content = null): JsonResponse
    {
        $response = new JsonResponse($content, 202);

        if (! is_null($location)) {
            $response->header('Location', $location);
        }

        return $response;
    }

    /**
     * Respond with a no content response.
     *
     * @return JsonResponse
     */
    public function noContent(): JsonResponse
    {
        return new JsonResponse(null, 204);
    }

    /**
     * @param Model $item
     * @param TransformerContract|Closure $transformer
     * @param string|null $type
     *
     * @return JsonResponse
     */
    public function responseItem($item, $transformer, string $type = null): JsonResponse
    {
        if (is_null($type) && $transformer instanceof TransformerContract) {
            $type = $transformer->type();
        }

        return $this->response(new ResourceItem($item, $transformer, $type));
    }

    /**
     * @param Collection $collection
     * @param TransformerContract|Closure $transformer
     * @param string|null $type
     *
     * @return JsonResponse
     */
    public function responseCollection(Collection $collection, $transformer, string $type = null): JsonResponse
    {
        if (is_null($type) && $transformer instanceof TransformerContract) {
            $type = $transformer->type();
        }

        return $this->response(new ResourceCollection($collection, $transformer, $type));
    }

    /**
     * @param AbstractPaginator $paginator
     * @param TransformerContract|Closure $transformer
     * @param array $queryParams
     * @param string|null $type
     *
     * @return JsonResponse
     */
    public function responsePagination(AbstractPaginator $paginator, $transformer, array $queryParams = [], string $type = null): JsonResponse
    {
        if (is_null($type) && $transformer instanceof TransformerContract) {
            $type = $transformer->type();
        }

        $collection = $paginator->getCollection();
        $resource   = new ResourceCollection($collection, $transformer, $type);

        $paginator->appends($queryParams);
        $resource->setPaginator(new IlluminatePaginatorAdapter($paginator));

        return $this->response($resource);
    }

    /**
     * @param ResourceAbstract $resource
     *
     * @return JsonResponse
     */
    public function response(ResourceAbstract $resource): JsonResponse
    {
        /** @var Scope $scope */
        $scope = $this->manager()->createData($resource);

        return new JsonResponse(
            $scope->toArray()
        );
    }
}