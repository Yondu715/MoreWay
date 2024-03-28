<?php

namespace App\Providers;

use App\Services\Auth\AuthService;
use App\Services\Auth\Interfaces\IAuthService;
use App\Services\Friend\FriendService;
use App\Services\Friend\Interfaces\IFriendService;
use App\Services\Place\Interfaces\IPlaceService;
use App\Services\Place\PlaceService;
use App\Services\Place\Review\Interfaces\IReviewService;
use App\Services\Place\Review\ReviewService;
use App\Services\User\Interfaces\IUserService;
use App\Services\User\UserService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public array $bindings = [
        IUserService::class => UserService::class,
        IAuthService::class => AuthService::class,
        IFriendService::class => FriendService::class,
        IPlaceService::class => PlaceService::class,
        IReviewService::class => ReviewService::class
    ];

    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
