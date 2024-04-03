<?php

namespace App\Providers;

use App\Lib\Cache\CacheManager;
use App\Lib\Cache\Interfaces\ICacheManager;
use App\Lib\Mail\Interfaces\IMailManager;
use App\Lib\Mail\MailManager;
use App\Lib\Storage\Interfaces\IStorageManager;
use App\Lib\Storage\StorageManager;
use App\Lib\Token\Interfaces\ITokenManager;
use App\Lib\Token\TokenManager;
use App\Repositories\BaseRepository\BaseRepository;
use App\Repositories\BaseRepository\Interfaces\IBaseRepository;
use App\Repositories\Friend\FriendRepository;
use App\Repositories\Friend\Interfaces\IFriendRepository;
use App\Repositories\Place\Interfaces\IPlaceRepository;
use App\Repositories\Place\PlaceRepository;
use App\Repositories\Place\Review\Interfaces\IReviewRepository;
use App\Repositories\Place\Review\ReviewRepository;
use App\Repositories\User\Interfaces\IUserRepository;
use App\Repositories\User\UserRepository;
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
        /** SERVICES */
        IUserService::class => UserService::class,
        IAuthService::class => AuthService::class,
        IFriendService::class => FriendService::class,
        IPlaceService::class => PlaceService::class,
        IReviewService::class => ReviewService::class,

        /** REPOSITORIES */
        IBaseRepository::class => BaseRepository::class,
        IUserRepository::class => UserRepository::class,
        IPlaceRepository::class => PlaceRepository::class,
        IReviewRepository::class => ReviewRepository::class,
        IFriendRepository::class => FriendRepository::class,

        /** LIBS */
        ITokenManager::class => TokenManager::class,
        IStorageManager::class => StorageManager::class,
        ICacheManager::class => CacheManager::class,
        IMailManager::class => MailManager::class
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
