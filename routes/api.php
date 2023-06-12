<?php

use App\Http\Controllers\Api\Admin\Area\AreaController as AdminAreaController;
use App\Http\Controllers\Api\Geo\CityController;
use App\Http\Controllers\Api\Site\Area\AreaController as SiteAreaController;
use App\Http\Controllers\Api\Trainer\Area\ActivityCategoryController;
use App\Http\Controllers\Api\Trainer\Area\ActivityController;
use App\Http\Controllers\Api\Trainer\Area\AreaController;
use App\Http\Controllers\Api\Trainer\Area\GroupCategoryController;
use App\Http\Controllers\Api\Trainer\Area\GroupController;
use App\Http\Controllers\Api\Trainer\AuthController;
use Illuminate\Support\Facades\Route;

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

Route::group([
    'middleware' => 'api',
    'prefix' => 'v1/auth'
], function ($router) {
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);
    Route::get('logout', [AuthController::class, 'logout']);
    Route::get('refresh', [AuthController::class, 'refresh']);
    Route::get('me', [AuthController::class, 'me']);
});
Route::group([
    'middleware' => 'api',
    'prefix' => 'v1'
], function ($router) {
    Route::group([
        'middleware' => 'api',
        'prefix' => 'area'
    ], function ($router) {
        Route::get('/', [SiteAreaController::class, 'list']);
        Route::get('/{id}', [SiteAreaController::class, 'show']);
    });
    Route::group([
        'middleware' => 'api',
        'prefix' => 'cities'
    ], function ($router) {
        Route::get('/', [CityController::class, 'list']);
    });
});

Route::group([
    'middleware' => 'admin',
    'prefix' => 'v1/admin'
], function ($router) {
    Route::group([
        'middleware' => 'admin',
        'prefix' => 'area'
    ], function ($router) {
        Route::post('add', [AdminAreaController::class, 'store']);
        Route::put('/update/{id}', [AdminAreaController::class, 'update']);
        Route::delete('/delete/{id}', [AdminAreaController::class, 'destroy']);
    });
});

Route::group([
    'middleware' => 'api',
    'prefix' => 'v1'
], function ($router) {
    Route::group([
        'middleware' => 'api',
        'prefix' => 'area'
    ], function ($router) {
        Route::post('add', [AreaController::class, 'store']);
        Route::put('/update/{id}', [AreaController::class, 'update']);
    });
    Route::group([
        'middleware' => 'api',
        'prefix' => 'group'
    ], function ($router) {
        Route::get('/category', [GroupCategoryController::class, 'list'])->middleware('auth:api');
        Route::get('/', [GroupController::class, 'list'])->middleware('auth:api');
        Route::get('/area/{area_id}', [GroupController::class, 'listByArea'])->middleware('auth:api');
        Route::post('/add', fn() => 'fdsfsd')->middleware('auth:api');
        Route::put('/update/{id}', [GroupController::class, 'update'])->middleware('auth:api');
        Route::delete('/delete/{id}', [GroupController::class, 'destroy'])->middleware('auth:api');
        Route::get('/{id}', [GroupController::class, 'show'])->middleware('auth:api');
        Route::post('/category/add', [GroupCategoryController::class, 'store'])->middleware('auth:api');
        Route::put('/category/update/{id}', [GroupCategoryController::class, 'update'])->middleware('auth:api');

        Route::delete('/category/delete/{id}', [GroupCategoryController::class, 'destroy'])->middleware('auth:api');
    });
    Route::group([
        'middleware' => 'api',
        'prefix' => 'activity'
    ], function ($router) {
        Route::get('/category', [ActivityCategoryController::class, 'list'])->middleware('auth:api');
        Route::get('/', [ActivityController::class, 'list'])->middleware('auth:api');
        Route::post('/add', [ActivityController::class, 'store'])->middleware('auth:api');
        Route::put('/update/{id}', [ActivityController::class, 'update'])->middleware('auth:api');
        Route::delete('/delete/{id}', [ActivityController::class, 'destroy'])->middleware('auth:api');
        Route::get('/{id}', [ActivityController::class, 'show'])->middleware('auth:api');
        Route::post('/category/add', [ActivityCategoryController::class, 'store'])->middleware('auth:api');
        Route::put('/category/update/{id}', [ActivityCategoryController::class, 'update'])->middleware('auth:api');
        Route::delete('/category/delete/{id}', [ActivityCategoryController::class, 'destroy'])->middleware('auth:api');
    });

});


