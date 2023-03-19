<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use LaravelJsonApi\Laravel\Facades\JsonApiRoute;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


JsonApiRoute::server('v1')->prefix('v1')->resources(function ($server) {
    $server->resource('posts', JsonApiController::class)
        ->relationships(function ($relations) {
            $relations->hasOne('author')->readOnly();
            $relations->hasMany('comments')->readOnly();
            $relations->hasMany('tags');
        });
});

JsonApiRoute::server('v1')
    ->namespace('Api')
    ->resources(function ($server) {
        $server->resource('students', StudentController::class);
        $server->resource('institutes', InstituteController::class);

        $server->resource('users', UserController::class)
            ->actions(function ($actions) {
                $actions->withId()->get('me');
                // $actions->withId()->get('webhooks');
                // $actions->withId()->post('update');
            });

        $server->resource('sessions', SessionController::class);
        $server->resource('guardians', GuardianController::class);
        $server->resource('grades');
        $server->resource('batches')
            ->actions(function ($actions) {
                // $actions->withId()->get('customers');
                // $actions->withId()->get('webhooks');
                // $actions->withId()->post('update');
            });
    });
