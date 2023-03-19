<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Batch\DestroyRequest;
use App\Http\Requests\Batch\StoreRequest;
use App\Http\Requests\Batch\UpdateRequest;
use App\JsonApi\V1\Batches\BatchSchema;
use App\Models\Batch;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\ApiController;
use App\Models\Institute;
use LaravelJsonApi\Core\Responses\DataResponse;
use LaravelJsonApi\Laravel\Http\Controllers\Actions\FetchOne;
use LaravelJsonApi\Laravel\Http\Requests\AnonymousCollectionQuery;
use LaravelJsonApi\Contracts\Routing\Route;
use LaravelJsonApi\Laravel\Http\Requests\AnonymousQuery;

/**
 * Class BatchController
 * @package App\Http\Controllers\Api
 */
class BatchController extends ApiController
{
    use FetchOne;

    public function __construct()
    {
        $this->authorizeResource(Batch::class);
    }

    /**
     * @param BatchSchema $schema
     * @param AnonymousCollectionQuery $request
     * @return DataResponse
     */
    public function index(BatchSchema $schema, AnonymousCollectionQuery $request): DataResponse
    {
        $instituteIds = Auth()->user()->instituteIds(true, true);

        if (in_array($request->institute_id, $instituteIds)) {
            $instituteIds = Institute::where('id', $request->institute_id)->pluck('id')->toArray();
        }

        $models = $schema
            ->repository()
            ->queryAll()
            ->withRequest($request)
            ->query();

        $models = $models->whereIntegerInRaw('institute_id', $instituteIds);

        if ($request->page()) {
            $models = $models->paginate($request->page());
        } else {
            $models = $models->get();
        }

        return new DataResponse($models);
    }

    /**
     * @param BatchSchema $schema
     * @param StoreRequest $request
     * @param AnonymousCollectionQuery $collectionQuery
     * @return DataResponse
     */
    public function store(BatchSchema $schema, StoreRequest $request, AnonymousQuery $query): DataResponse
    {
        return new DataResponse(app()->batch->store($request));
    }

    /**
     * @param BatchSchema $schema
     * @param UpdateRequest $request
     * @param AnonymousCollectionQuery $collectionQuery
     * @return DataResponse
     */
    public function update(Route $route, BatchSchema $schema, UpdateRequest $request, AnonymousCollectionQuery $collectionQuery): DataResponse
    {
        return new DataResponse(app()->batch->update($request, $route->model()));
    }

    /**
     * Fetch zero to one JSON API resource by id.
     *
     * @param PostSchema $schema
     * @param PostQuery $request
     * @param Post $post
     * @return \Illuminate\Contracts\Support\Responsable|\Illuminate\Http\Response
     */
    public function show(BatchSchema $schema, AnonymousQuery $request, Batch $batch)
    {
        $model = $schema
            ->repository()
            ->queryOne($batch)
            ->withRequest($request)
            ->first();

        return new DataResponse($model);
    }

    /**
     * @param DestroyRequest $request
     * @return JsonResponse
     */
    public function destroy(Batch $batch): JsonResponse
    {
        if (app()->batch->destroy($batch)) {
            return response()->json(
                $this->success('Batch successfully deleted.')
            );
        }
        return response()->json(
            $this->fail('Something went wrong!')
        );
    }
}
