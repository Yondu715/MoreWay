<?php

use App\Infrastructure\Http\Controllers\Api\V1\AchievementController;
use App\Infrastructure\Http\Controllers\Api\V1\AuthController;
use App\Infrastructure\Http\Controllers\Api\V1\FriendController;
use App\Infrastructure\Http\Controllers\Api\V1\PlaceController;
use App\Infrastructure\Http\Controllers\Api\V1\RatingController;
use App\Infrastructure\Http\Controllers\Api\V1\RouteController;
use App\Infrastructure\Http\Controllers\Api\V1\UserController;
use Illuminate\Support\Facades\Route;

Route::patterns([
    'userId' => '[0-9]+',
    'requestId' => '[0-9]+',
    'placeId' => '[0-9]+'
]);

Route::prefix('auth')
    ->group(function () {
        Route::middleware('auth:api')
            ->group(function () {
                Route::post('logout', [AuthController::class, 'logout']);
                Route::get('me', [AuthController::class, 'me']);
            });
        Route::post('refresh-token', [AuthController::class, 'refresh']);
        Route::post('login', [AuthController::class, 'login']);
        Route::post('register', [AuthController::class, 'register']);
        Route::prefix('/password')
            ->group(function () {
                Route::post('forgot', [AuthController::class, 'forgotPassword']);
                Route::post('verify-code', [AuthController::class, 'verifyPasswordCode']);
                Route::put('reset', [AuthController::class, 'resetPassword']);
            });
    });

Route::prefix('users')
    ->middleware('auth:api', 'role:user')
    ->group(function () {
        Route::get('/', [UserController::class, 'getUsers']);
        Route::prefix('/{userId}')
            ->group(function () {
                Route::get('/', [UserController::class, 'getUser']);
                Route::middleware('owner')
                    ->group(function (){
                        Route::patch('/', [UserController::class, 'changeData']);
                        Route::delete('/', [UserController::class, 'delete']);
                        Route::put('/avatar', [UserController::class, 'changeAvatar']);
                        Route::put('/password', [UserController::class, 'changePassword']);
                        Route::prefix('/friends')
                            ->group(function (){
                                Route::get('/', [FriendController::class, 'getFriends']);
                                Route::delete('/{friendId}', [FriendController::class, 'deleteFriend']);
                                Route::get('/requests', [FriendController::class, 'getFriendRequests']);
                            });
                        Route::prefix('/constructor')
                            ->group(function (){
                                Route::get('/', [RouteController::class, 'getUserRouteConstructor']);
                                Route::put('/', [RouteController::class, 'changeUserRouteConstructor']);
                            });
                        Route::prefix('/active-route')
                            ->group(function (){
                                Route::get('/', [RouteController::class, 'getActiveUserRoute']);
                                Route::patch('/', [RouteController::class, 'changeActiveUserRoute']);
                            });
                        Route::prefix('/favorite-routes')
                            ->group(function (){
                                Route::post('/', [RouteController::class, 'addRouteToUserFavorite']);
                                Route::delete('/{routeId}', [RouteController::class, 'deleteRouteFromUserFavorite']);
                            });
                        Route::delete('/routes/{routeId}', [RouteController::class, 'deleteUserRoute']);
                    });
                Route::get('/routes', [RouteController::class, 'getUsersRoutes']);
                Route::get('/favorite-routes', [RouteController::class, 'getFavoriteUserRoutes']);

                Route::get('/achievements', [AchievementController::class, 'getUserAchievements']);
            });
    });

Route::prefix('achievements')
    ->middleware('auth:api', 'role:user')
    ->group(function () {
        Route::get('/', [AchievementController::class, 'getAchievements']);
        Route::get('/types', [AchievementController::class, 'getAchievementsTypes']);
    });

Route::prefix('rating')
    ->middleware('auth:api', 'role:user')
    ->group(function () {
        Route::get('/', [RatingController::class, 'getRating']);
    });

Route::prefix('friends')
    ->middleware('auth:api', 'role:user')
    ->group(function () {
        Route::middleware('owner')
            ->group(function () {
                Route::post('/requests', [FriendController::class, 'addFriendRequest']);
                Route::put('/requests', [FriendController::class, 'acceptFriendRequest']);
            });
        Route::delete('/requests/{requestId}', [FriendController::class, 'rejectFriendRequest']);
    });

Route::prefix('places')
    ->middleware('auth:api', 'role:user', 'content.type')
    ->group(function () {
        Route::get('/', [PlaceController::class, 'getPlaces']);
        Route::get('/filters', [PlaceController::class, 'getFilters']);
        Route::get('/{placeId}', [PlaceController::class, 'getPlace']);
        Route::prefix('/{placeId}/reviews')
            ->group(function () {
                Route::middleware('owner')
                    ->post('/', [PlaceController::class, 'createReview']);
                Route::get('/', [PlaceController::class, 'getReviews']);
            });
    });

Route::prefix('routes')
    ->middleware('auth:api', 'role:user')
    ->group(function () {
        Route::get('/', [RouteController::class, 'getRoutes']);
        Route::get('/filters', [RouteController::class, 'getFilters']);
        Route::get('/{routeId}', [RouteController::class, 'getRoute']);
        Route::middleware('owner')
            ->group(function () {
                Route::post('/', [RouteController::class, 'createRoute']);
                Route::put('/route-points/status',[RouteController::class, 'completedRoutePoint']);
            });
        Route::prefix('/{routeId}/reviews')
            ->group(function () {
                Route::middleware('owner')
                    ->post('/', [RouteController::class, 'createReview']);
                Route::get('/', [RouteController::class, 'getReviews']);
            });
    });
