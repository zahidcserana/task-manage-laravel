<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Admission\DestroyRequest;
use App\Http\Requests\Admission\StoreRequest;
use App\Http\Requests\Admission\UpdateRequest;
use App\JsonApi\V1\admissions\AdmissionSchema;
use App\Models\Admission;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\ApiController;
use App\Models\Institute;
use LaravelJsonApi\Core\Responses\DataResponse;
use LaravelJsonApi\Core\Responses\RelatedResponse;
use LaravelJsonApi\Laravel\Http\Controllers\Actions\FetchOne;
use LaravelJsonApi\Laravel\Http\Requests\AnonymousCollectionQuery;
use LaravelJsonApi\Contracts\Routing\Route;
use LaravelJsonApi\Laravel\Http\Requests\AnonymousQuery;

/**
 * Class AdmissionController
 * @package App\Http\Controllers\Api
 */
class AdmissionController extends ApiController
{
    use FetchOne;

    public function __construct()
    {
        $this->authorizeResource(Admission::class);
    }

    /**
     * @param AdmissionSchema $schema
     * @param AnonymousCollectionQuery $request
     * @return DataResponse
     */
    public function index(AdmissionSchema $schema, AnonymousCollectionQuery $request): DataResponse
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
     * @param AdmissionSchema $schema
     * @param StoreRequest $request
     * @param AnonymousCollectionQuery $collectionQuery
     * @return DataResponse
     */
    public function store(AdmissionSchema $schema, StoreRequest $request, AnonymousQuery $query): DataResponse
    {
        return new DataResponse(app()->admission->store($request));
    }

    /**
     * @param AdmissionSchema $schema
     * @param UpdateRequest $request
     * @param AnonymousCollectionQuery $collectionQuery
     * @return DataResponse
     */
    public function update(Route $route, AdmissionSchema $schema, UpdateRequest $request, AnonymousCollectionQuery $collectionQuery): DataResponse
    {
        return new DataResponse(app()->admission->update($request, $route->model()));
    }

    /**
     * Fetch zero to one JSON API resource by id.
     *
     * @param PostSchema $schema
     * @param PostQuery $request
     * @param Post $post
     * @return \Illuminate\Contracts\Support\Responsable|\Illuminate\Http\Response
     */
    public function show(AdmissionSchema $schema, AnonymousQuery $request, Admission $admission)
    {
        $model = $schema
            ->repository()
            ->queryOne($admission)
            ->withRequest($request)
            ->first();

        return new DataResponse($model);
    }

    /**
     * @param DestroyRequest $request
     * @return JsonResponse
     */
    public function destroy(Admission $admission): JsonResponse
    {
        if (app()->admission->destroy($admission)) {
            return response()->json(
                $this->success('Admission successfully deleted.')
            );
        }
        return response()->json(
            $this->fail('Something went wrong!')
        );
    }

    public function showRelatedBatch(AdmissionSchema $schema, Admission $admission)
    {
      $batch = $schema
        ->repository()
        ->queryToOne($admission, 'batch')
        ->first();

      return new RelatedResponse($admission, 'batch', $batch);
    }

    public function showRelatedStudent(AdmissionSchema $schema, Admission $admission)
    {
      $student = $schema
        ->repository()
        ->queryToOne($admission, 'student')
        ->first();

      return new RelatedResponse($admission, 'student', $student);
    }
}
