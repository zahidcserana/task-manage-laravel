<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Institute\DestroyRequest;
use App\Http\Requests\Institute\StoreRequest;
use App\Http\Requests\Institute\UpdateRequest;
use App\JsonApi\V1\Institutes\InstituteSchema;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\ApiController;
use App\Models\Institute;
use LaravelJsonApi\Core\Responses\DataResponse;
use LaravelJsonApi\Laravel\Http\Controllers\Actions\FetchOne;
use LaravelJsonApi\Laravel\Http\Requests\AnonymousCollectionQuery;
use LaravelJsonApi\Contracts\Routing\Route;
use LaravelJsonApi\Laravel\Http\Requests\AnonymousQuery;

/**
 * Class InstituteController
 * @package App\Http\Controllers\Api
 */
class InstituteController extends ApiController
{
    use FetchOne;

    public function __construct()
    {
        $this->authorizeResource(Institute::class);
    }

    /**
     * @param InstituteSchema $schema
     * @param AnonymousCollectionQuery $request
     * @return DataResponse
     */
    public function index(InstituteSchema $schema, AnonymousCollectionQuery $request): DataResponse
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

        $models = $models->whereIntegerInRaw('id', $instituteIds);

        if ($request->page()) {
            $models = $models->paginate($request->page());
        } else {
            $models = $models->get();
        }

        return new DataResponse($models);
    }

    /**
     * @param InstituteSchema $schema
     * @param StoreRequest $request
     * @param AnonymousCollectionQuery $collectionQuery
     * @return DataResponse
     */
    public function store(InstituteSchema $schema, StoreRequest $request, AnonymousQuery $query): DataResponse
    {
        return new DataResponse(app()->institute->store($request));
    }

    /**
     * @param InstituteSchema $schema
     * @param UpdateRequest $request
     * @param AnonymousCollectionQuery $collectionQuery
     * @return DataResponse
     */
    public function update(Route $route, InstituteSchema $schema, UpdateRequest $request, AnonymousCollectionQuery $collectionQuery): DataResponse
    {
        return new DataResponse(app()->institute->update($request, $route->model()));
    }

    /**
     * Fetch zero to one JSON API resource by id.
     *
     * @param PostSchema $schema
     * @param PostQuery $request
     * @param Post $post
     * @return \Illuminate\Contracts\Support\Responsable|\Illuminate\Http\Response
     */
    public function show(InstituteSchema $schema, AnonymousQuery $request, Institute $institute)
    {
        $model = $schema
            ->repository()
            ->queryOne($institute)
            ->withRequest($request)
            ->first();

        return new DataResponse($model);
    }

    /**
     * @param DestroyRequest $request
     * @return JsonResponse
     */
    public function destroy(Institute $institute): JsonResponse
    {
        if (app()->institute->destroy($institute)) {
            return response()->json(
                $this->success('Institute successfully deleted.')
            );
        }

        return response()->json(
            $this->fail('Something went wrong!')
        );
    }
}
