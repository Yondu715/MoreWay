<?php

namespace App\Infrastructure\Providers;

use App\Application\Contracts\In\Services\IAuthService;
use App\Application\Contracts\In\Services\IFriendService;
use App\Application\Contracts\In\Services\IPlaceReviewService;
use App\Application\Contracts\In\Services\IPlaceService;
use App\Application\Contracts\In\Services\IRouteService;
use App\Application\Contracts\In\Services\IUserService;
use App\Application\Contracts\Out\Managers\ICacheManager;
use App\Application\Contracts\Out\Managers\IMailManager;
use App\Application\Contracts\Out\Managers\IStorageManager;
use App\Application\Contracts\Out\Managers\ITokenManager;
use App\Application\Contracts\Out\Repositories\IFriendRepository;
use App\Application\Contracts\Out\Repositories\IPlaceRepository;
use App\Application\Contracts\Out\Repositories\IPlaceReviewRepository;
use App\Application\Contracts\Out\Repositories\IRouteRepository;
use App\Application\Contracts\Out\Repositories\IUserRepository;
use App\Application\Services\Auth\AuthService;
use App\Application\Services\Friend\FriendService;
use App\Application\Services\Place\PlaceService;
use App\Application\Services\Place\Review\PlaceReviewService;
use App\Application\Services\Route\RouteService;
use App\Application\Services\User\UserService;
use App\Infrastructure\Database\Repositories\Friend\FriendRepository;
use App\Infrastructure\Database\Repositories\Place\PlaceRepository;
use App\Infrastructure\Database\Repositories\Place\Review\PlaceReviewRepository;
use App\Infrastructure\Database\Repositories\Route\RouteRepository;
use App\Infrastructure\Database\Repositories\User\UserRepository;
use App\Infrastructure\Database\Transaction\Interface\ITransactionManager;
use App\Infrastructure\Database\Transaction\TransactionManager;
use App\Infrastructure\Managers\Cache\CacheManager;
use App\Infrastructure\Managers\Mail\MailManager;
use App\Infrastructure\Managers\Storage\StorageManager;
use App\Infrastructure\Managers\Token\TokenManager;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public array $bindings = [
        /** SERVICES */
        IUserService::class => UserService::class,
        IAuthService::class => AuthService::class,
        IFriendService::class => FriendService::class,
        IPlaceService::class => PlaceService::class,
        IPlaceReviewService::class => PlaceReviewService::class,
        IRouteService::class => RouteService::class,

        /** REPOSITORIES */
        IUserRepository::class => UserRepository::class,
        IPlaceRepository::class => PlaceRepository::class,
        IPlaceReviewRepository::class => PlaceReviewRepository::class,
        IFriendRepository::class => FriendRepository::class,
        IRouteRepository::class => RouteRepository::class,

        /** LIBS */
        ITokenManager::class => TokenManager::class,
        IStorageManager::class => StorageManager::class,
        ICacheManager::class => CacheManager::class,
        IMailManager::class => MailManager::class,
        ITransactionManager::class => TransactionManager::class
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
