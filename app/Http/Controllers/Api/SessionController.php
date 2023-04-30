<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Session\DestroyRequest;
use App\Http\Requests\Session\StoreRequest;
use App\Http\Requests\Session\UpdateRequest;
use App\JsonApi\V1\Sessions\SessionSchema;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\ApiController;
use App\Models\Session;
use App\Models\Institute;
use LaravelJsonApi\Core\Responses\DataResponse;
use LaravelJsonApi\Laravel\Http\Controllers\Actions\FetchOne;
use LaravelJsonApi\Laravel\Http\Requests\AnonymousCollectionQuery;
use LaravelJsonApi\Contracts\Routing\Route;
use LaravelJsonApi\Laravel\Http\Requests\AnonymousQuery;

/**
 * Class SessionController
 * @package App\Http\Controllers\Api
 */
class SessionController extends ApiController
{
    use FetchOne;

    public function __construct()
    {
        $this->authorizeResource(Session::class);
    }

    /**
     * @param SessionSchema $schema
     * @param AnonymousCollectionQuery $request
     * @return DataResponse
     */
    public function index(SessionSchema $schema, AnonymousCollectionQuery $request): DataResponse
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
     * @param SessionSchema $schema
     * @param StoreRequest $request
     * @param AnonymousCollectionQuery $collectionQuery
     * @return DataResponse
     */
    public function store(SessionSchema $schema, StoreRequest $request, AnonymousQuery $query): DataResponse
    {
        return new DataResponse(app()->sessionyear->store($request));
    }

    /**
     * @param SessionSchema $schema
     * @param UpdateRequest $request
     * @param AnonymousCollectionQuery $collectionQuery
     * @return DataResponse
     */
    public function update(Route $route, SessionSchema $schema, UpdateRequest $request, AnonymousCollectionQuery $collectionQuery): DataResponse
    {
        return new DataResponse(app()->sessionyear->update($request, $route->model()));
    }

    /**
     * Fetch zero to one JSON API resource by id.
     *
     * @param PostSchema $schema
     * @param PostQuery $request
     * @param Post $post
     * @return \Illuminate\Contracts\Support\Responsable|\Illuminate\Http\Response
     */
    public function show(SessionSchema $schema, AnonymousQuery $request, Session $session)
    {
        $model = $schema
            ->repository()
            ->queryOne($session)
            ->withRequest($request)
            ->first();

        return new DataResponse($model);
    }

    /**
     * @param DestroyRequest $request
     * @return JsonResponse
     */
    public function destroy(Session $session): JsonResponse
    {
        if (app()->sessionyear->destroy($session)) {
            return response()->json(
                $this->success('Session successfully deleted.')
            );
        }

        return response()->json(
            $this->fail('Something went wrong!')
        );
    }
}
