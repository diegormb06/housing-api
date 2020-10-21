<?php

use App\Http\Controllers\Api\RealStateSearchController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\RealStateImageController;
use App\Http\Controllers\Api\RealStateController;
use App\Http\Controllers\Api\UserController;


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


Route::prefix('v1')->middleware('auth:api')->group(function () {
    Route::prefix('auth')->group(function () {
        Route::post('login', [AuthController::class, 'login'])->withoutMiddleware('auth:api');
        Route::post('logout', [AuthController::class, 'logout']);
        Route::post('refresh', [AuthController::class, 'refresh']);
        Route::post('me', [AuthController::class, 'me']);
    });

    Route::resource('users', UserController::class);
    Route::resource('real-states', RealStateController::class);
    Route::resource('category', CategoryController::class);
    Route::get('/category/{id}/real-states', [CategoryController::class, 'realStates']);

    Route::name('images')->prefix('images')->group(function () {
        Route::delete('/{id}', [RealStateImageController::class, 'remove']);
        Route::put('/set-thumb/{imageId}/{realStateId}', [RealStateImageController::class, 'setThumb']);
    });

    Route::get('search', [RealStateSearchController::class, 'index'])->withoutMiddleware('auth:api');
});
