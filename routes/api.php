<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use LaravelJsonApi\Laravel\Facades\JsonApiRoute;
use LaravelJsonApi\Laravel\Http\Controllers\JsonApiController;

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
    $server->resource('institutes', JsonApiController::class);
    $server->resource('users', JsonApiController::class);
    $server->resource('grades', JsonApiController::class);
    $server->resource('guardians', JsonApiController::class);
    $server->resource('students', JsonApiController::class);

    $server->resource('posts', JsonApiController::class)
        ->relationships(function ($relations) {
            $relations->hasOne('author')->readOnly();
            $relations->hasMany('comments')->readOnly();
            $relations->hasMany('tags');
        });
});
