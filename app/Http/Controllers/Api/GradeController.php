<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Grade\DestroyRequest;
use App\Http\Requests\Grade\StoreRequest;
use App\Http\Requests\Grade\UpdateRequest;
use App\JsonApi\V1\Grades\GradeSchema;
use App\Models\Grade;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\ApiController;
use App\Models\Institute;
use LaravelJsonApi\Core\Responses\DataResponse;
use LaravelJsonApi\Laravel\Http\Controllers\Actions\FetchOne;
use LaravelJsonApi\Laravel\Http\Requests\AnonymousCollectionQuery;
use LaravelJsonApi\Contracts\Routing\Route;
use LaravelJsonApi\Laravel\Http\Requests\AnonymousQuery;

/**
 * Class GradeController
 * @package App\Http\Controllers\Api
 */
class GradeController extends ApiController
{
    use FetchOne;

    public function __construct()
    {
        $this->authorizeResource(Grade::class);
    }

    /**
     * @param GradeSchema $schema
     * @param AnonymousCollectionQuery $request
     * @return DataResponse
     */
    public function index(GradeSchema $schema, AnonymousCollectionQuery $request): DataResponse
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
     * @param GradeSchema $schema
     * @param StoreRequest $request
     * @param AnonymousCollectionQuery $collectionQuery
     * @return DataResponse
     */
    public function store(GradeSchema $schema, StoreRequest $request, AnonymousQuery $query): DataResponse
    {
        return new DataResponse(app()->grade->store($request));
    }

    /**
     * @param GradeSchema $schema
     * @param UpdateRequest $request
     * @param AnonymousCollectionQuery $collectionQuery
     * @return DataResponse
     */
    public function update(Route $route, GradeSchema $schema, UpdateRequest $request, AnonymousCollectionQuery $collectionQuery): DataResponse
    {
        return new DataResponse(app()->grade->update($request, $route->model()));
    }

    /**
     * Fetch zero to one JSON API resource by id.
     *
     * @param PostSchema $schema
     * @param PostQuery $request
     * @param Post $post
     * @return \Illuminate\Contracts\Support\Responsable|\Illuminate\Http\Response
     */
    public function show(GradeSchema $schema, AnonymousQuery $request, Grade $grade)
    {
        $model = $schema
            ->repository()
            ->queryOne($grade)
            ->withRequest($request)
            ->first();

        return new DataResponse($model);
    }

    /**
     * @param DestroyRequest $request
     * @return JsonResponse
     */
    public function destroy(Grade $grade): JsonResponse
    {
        if (app()->grade->destroy($grade)) {
            return response()->json(
                $this->success('Grade successfully deleted.')
            );
        }

        return response()->json(
            $this->fail('Something went wrong!')
        );
    }
}
