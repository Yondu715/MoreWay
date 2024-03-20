<?php

namespace App\Providers;

use App\Services\Auth\AuthService;
use App\Services\Auth\Interfaces\IAuthService;
use App\Services\Friend\FriendService;
use App\Services\Friend\Interfaces\IFriendService;
use App\Services\User\Interfaces\IUserService;
use App\Services\User\UserService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{

    public $bindings = [
        IUserService::class => UserService::class,
        IAuthService::class => AuthService::class,
        IFriendService::class => FriendService::class
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
