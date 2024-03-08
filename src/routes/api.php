<?php

use App\Http\Controllers\Api\V1\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::prefix('users')
    ->group(function () {
        Route::get('/{userId}', [UserController::class, 'getUser']);
        Route::patch('/{userId}', [UserController::class, 'changeData']);
        Route::delete('/{userId}', [UserController::class, 'delete']);
        Route::patch('/{userId}/avatar', [UserController::class, 'changeAvatar']);
        Route::post('/{userId}/password', [UserController::class, 'changePassword']);
        Route::post('/search', [UserController::class, 'findUsers']);
    });
