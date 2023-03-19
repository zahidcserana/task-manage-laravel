<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\User\DestroyRequest;
use App\Http\Requests\User\StoreRequest;
use App\Http\Requests\User\UpdateRequest;
use App\JsonApi\V1\Users\UserSchema;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\ApiController;
use App\Models\Institute;
use App\Models\User;
use LaravelJsonApi\Core\Responses\DataResponse;
use LaravelJsonApi\Laravel\Http\Controllers\Actions\FetchOne;
use LaravelJsonApi\Laravel\Http\Requests\AnonymousCollectionQuery;
use LaravelJsonApi\Contracts\Routing\Route;
use LaravelJsonApi\Laravel\Http\Requests\AnonymousQuery;

/**
 * Class UserController
 * @package App\Http\Controllers\Api
 */
class UserController extends ApiController
{
    use FetchOne;

    public function __construct()
    {
        $this->authorizeResource(User::class);
    }

    /**
     * @param UserSchema $schema
     * @param AnonymousCollectionQuery $request
     * @return DataResponse
     */
    public function index(UserSchema $schema, AnonymousCollectionQuery $request): DataResponse
    {
        // $instituteIds = Auth()->user()->instituteIds(true, true);

        // if (in_array($request->institute_id, $instituteIds)) {
        //     $instituteIds = User::where('id', $request->institute_id)->pluck('id')->toArray();
        // }


        $models = $schema
            ->repository()
            ->queryAll()
            ->withRequest($request)
            ->query();

        // $models = $models->whereIntegerInRaw('institute_id', $instituteIds);

        if ($request->page()) {
            $models = $models->paginate($request->page());
        } else {
            $models = $models->get();
        }

        return new DataResponse($models);
    }

    /**
     * @param UserSchema $schema
     * @param StoreRequest $request
     * @param AnonymousCollectionQuery $collectionQuery
     * @return DataResponse
     */
    public function store(UserSchema $schema, StoreRequest $request, AnonymousQuery $query): DataResponse
    {
        return new DataResponse(app()->user->store($request));
    }

    /**
     * @param UserSchema $schema
     * @param UpdateRequest $request
     * @param AnonymousCollectionQuery $collectionQuery
     * @return DataResponse
     */
    public function update(Route $route, UserSchema $schema, UpdateRequest $request, AnonymousCollectionQuery $collectionQuery): DataResponse
    {
        return new DataResponse(app()->user->update($request, $route->model()));
    }

    /**
     * Fetch zero to one JSON API resource by id.
     *
     * @param PostSchema $schema
     * @param PostQuery $request
     * @param Post $post
     * @return \Illuminate\Contracts\Support\Responsable|\Illuminate\Http\Response
     */
    public function show(UserSchema $schema, AnonymousQuery $request, User $user)
    {
        $model = $schema
            ->repository()
            ->queryOne($user)
            ->withRequest($request)
            ->first();

        return new DataResponse($model);
    }

    public function me(UserSchema $schema, AnonymousQuery $request, User $user): DataResponse
    {
        $model = $schema
            ->repository()
            ->queryOne($user)
            ->withRequest($request)
            ->first();

        return DataResponse::make($model)
            ->withMeta(['token' => $model->createToken("Testing")->plainTextToken]);
    }

    /**
     * @param DestroyRequest $request
     * @return JsonResponse
     */
    public function destroy(User $user): JsonResponse
    {
        if (app()->user->destroy($user)) {
            return response()->json(
                $this->success('User successfully deleted.')
            );
        }

        return response()->json(
            $this->fail('Something went wrong!')
        );
    }
}
