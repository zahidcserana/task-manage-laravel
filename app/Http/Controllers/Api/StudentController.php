<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Student\DestroyRequest;
use App\Http\Requests\Student\StoreRequest;
use App\Http\Requests\Student\UpdateRequest;
use App\JsonApi\V1\Students\StudentSchema;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\ApiController;
use App\Models\Student;
use App\Models\Institute;
use LaravelJsonApi\Core\Responses\DataResponse;
use LaravelJsonApi\Laravel\Http\Controllers\Actions\FetchOne;
use LaravelJsonApi\Laravel\Http\Requests\AnonymousCollectionQuery;
use LaravelJsonApi\Contracts\Routing\Route;
use LaravelJsonApi\Laravel\Http\Requests\AnonymousQuery;

/**
 * Class StudentController
 * @package App\Http\Controllers\Api
 */
class StudentController extends ApiController
{
    use FetchOne;

    public function __construct()
    {
        $this->authorizeResource(Student::class);
    }

    /**
     * @param StudentSchema $schema
     * @param AnonymousCollectionQuery $request
     * @return DataResponse
     */
    public function index(StudentSchema $schema, AnonymousCollectionQuery $request): DataResponse
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
     * @param StudentSchema $schema
     * @param StoreRequest $request
     * @param AnonymousCollectionQuery $collectionQuery
     * @return DataResponse
     */
    public function store(StudentSchema $schema, StoreRequest $request, AnonymousQuery $query): DataResponse
    {
        return new DataResponse(app()->student->store($request));
    }

    /**
     * @param StudentSchema $schema
     * @param UpdateRequest $request
     * @param AnonymousCollectionQuery $collectionQuery
     * @return DataResponse
     */
    public function update(Route $route, StudentSchema $schema, UpdateRequest $request, AnonymousCollectionQuery $collectionQuery): DataResponse
    {
        return new DataResponse(app()->student->update($request, $route->model()));
    }

    /**
     * Fetch zero to one JSON API resource by id.
     *
     * @param PostSchema $schema
     * @param PostQuery $request
     * @param Post $post
     * @return \Illuminate\Contracts\Support\Responsable|\Illuminate\Http\Response
     */
    public function show(StudentSchema $schema, AnonymousQuery $request, Student $student)
    {
        $model = $schema
            ->repository()
            ->queryOne($student)
            ->withRequest($request)
            ->first();

        return new DataResponse($model);
    }

    /**
     * @param DestroyRequest $request
     * @return JsonResponse
     */
    public function destroy(Student $student): JsonResponse
    {
        if (app()->student->destroy($student)) {
            return response()->json(
                $this->success('Student successfully deleted.')
            );
        }

        return response()->json(
            $this->fail('Something went wrong!')
        );
    }
}
