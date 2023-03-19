<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Guardian\DestroyRequest;
use App\Http\Requests\Guardian\StoreRequest;
use App\Http\Requests\Guardian\UpdateRequest;
use App\JsonApi\V1\Guardians\GuardianSchema;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\ApiController;
use App\Models\Guardian;
use App\Models\Institute;
use LaravelJsonApi\Core\Responses\DataResponse;
use LaravelJsonApi\Laravel\Http\Controllers\Actions\FetchOne;
use LaravelJsonApi\Laravel\Http\Requests\AnonymousCollectionQuery;
use LaravelJsonApi\Contracts\Routing\Route;
use LaravelJsonApi\Laravel\Http\Requests\AnonymousQuery;

/**
 * Class GuardianController
 * @package App\Http\Controllers\Api
 */
class GuardianController extends ApiController
{
    use FetchOne;

    public function __construct()
    {
        $this->authorizeResource(Guardian::class);
    }

    /**
     * @param GuardianSchema $schema
     * @param AnonymousCollectionQuery $request
     * @return DataResponse
     */
    public function index(GuardianSchema $schema, AnonymousCollectionQuery $request): DataResponse
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
     * @param GuardianSchema $schema
     * @param StoreRequest $request
     * @param AnonymousCollectionQuery $collectionQuery
     * @return DataResponse
     */
    public function store(GuardianSchema $schema, StoreRequest $request, AnonymousQuery $query): DataResponse
    {
        return new DataResponse(app()->guardian->store($request));
    }

    /**
     * @param GuardianSchema $schema
     * @param UpdateRequest $request
     * @param AnonymousCollectionQuery $collectionQuery
     * @return DataResponse
     */
    public function update(Route $route, GuardianSchema $schema, UpdateRequest $request, AnonymousCollectionQuery $collectionQuery): DataResponse
    {
        return new DataResponse(app()->guardian->update($request, $route->model()));
    }

    /**
     * Fetch zero to one JSON API resource by id.
     *
     * @param PostSchema $schema
     * @param PostQuery $request
     * @param Post $post
     * @return \Illuminate\Contracts\Support\Responsable|\Illuminate\Http\Response
     */
    public function show(GuardianSchema $schema, AnonymousQuery $request, Guardian $guardian)
    {
        $model = $schema
            ->repository()
            ->queryOne($guardian)
            ->withRequest($request)
            ->first();

        return new DataResponse($model);
    }

    /**
     * @param DestroyRequest $request
     * @return JsonResponse
     */
    public function destroy(Guardian $guardian): JsonResponse
    {
        if (app()->guardian->destroy($guardian)) {
            return response()->json(
                $this->success('Guardian successfully deleted.')
            );
        }

        return response()->json(
            $this->fail('Something went wrong!')
        );
    }
}
