<?php

namespace App\Infrastructure\Providers;

use App\Application\Contracts\In\Services\IAuthService;
use App\Application\Contracts\In\Services\IFriendshipService;
use App\Application\Contracts\In\Services\IPlaceFilterService;
use App\Application\Contracts\In\Services\IPlaceReviewService;
use App\Application\Contracts\In\Services\IPlaceService;
use App\Application\Contracts\In\Services\IRouteService;
use App\Application\Contracts\In\Services\IUserService;
use App\Application\Contracts\Out\InfrastructureManagers\ICacheManager;
use App\Application\Contracts\Out\InfrastructureManagers\IHashManager;
use App\Application\Contracts\Out\InfrastructureManagers\IMailManager;
use App\Application\Contracts\Out\InfrastructureManagers\IStorageManager;
use App\Application\Contracts\Out\InfrastructureManagers\ITokenManager;
use App\Application\Contracts\Out\Notification\INotify;
use App\Application\Contracts\Out\Repositories\IFriendshipRepository;
use App\Application\Contracts\Out\Repositories\ILocalityRepository;
use App\Application\Contracts\Out\Repositories\IPlaceRepository;
use App\Application\Contracts\Out\Repositories\IPlaceReviewRepository;
use App\Application\Contracts\Out\Repositories\IRouteRepository;
use App\Application\Contracts\Out\Repositories\IPlaceTypeRepository;
use App\Application\Contracts\Out\Repositories\IUserRepository;
use App\Application\Services\Auth\AuthService;
use App\Application\Services\Friend\FriendshipService;
use App\Application\Services\Place\Filter\PlaceFilterService;
use App\Application\Services\Place\PlaceService;
use App\Application\Services\Place\Review\PlaceReviewService;
use App\Application\Services\Route\RouteService;
use App\Application\Services\User\UserService;
use App\Domain\Contracts\In\DomainManagers\IDistanceManager;
use App\Domain\Managers\Distance\DistanceManager;
use App\Infrastructure\Database\Repositories\Friend\FriendshipRepository;
use App\Infrastructure\Database\Repositories\Place\Locality\LocalityRepository;
use App\Infrastructure\Database\Repositories\Place\PlaceRepository;
use App\Infrastructure\Database\Repositories\Place\Review\PlaceReviewRepository;
use App\Infrastructure\Database\Repositories\Place\Type\PlaceTypeRepository;
use App\Infrastructure\Database\Repositories\Route\RouteRepository;
use App\Infrastructure\Database\Repositories\User\UserRepository;
use App\Infrastructure\Database\Transaction\Interface\ITransactionManager;
use App\Infrastructure\Database\Transaction\TransactionManager;
use App\Infrastructure\Managers\Cache\CacheManager;
use App\Infrastructure\Managers\Hash\HashManager;
use App\Infrastructure\Managers\Mail\MailManager;
use App\Infrastructure\Managers\Storage\StorageManager;
use App\Infrastructure\Managers\Token\TokenManager;
use App\Infrastructure\Websocket\Controllers\Friend\FriendNotifier;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public array $bindings = [
        /** SERVICES */
        IUserService::class => UserService::class,
        IAuthService::class => AuthService::class,
        IFriendshipService::class => FriendshipService::class,
        IPlaceService::class => PlaceService::class,
        IPlaceReviewService::class => PlaceReviewService::class,
        IRouteService::class => RouteService::class,
        IPlaceFilterService::class => PlaceFilterService::class,

        /** REPOSITORIES */
        IUserRepository::class => UserRepository::class,
        IPlaceRepository::class => PlaceRepository::class,
        IPlaceReviewRepository::class => PlaceReviewRepository::class,
        IFriendshipRepository::class => FriendshipRepository::class,
        IRouteRepository::class => RouteRepository::class,
        ILocalityRepository::class => LocalityRepository::class,
        IPlaceTypeRepository::class => PlaceTypeRepository::class,

        /** InfrastructureManagers */
        ITokenManager::class => TokenManager::class,
        IStorageManager::class => StorageManager::class,
        ICacheManager::class => CacheManager::class,
        IMailManager::class => MailManager::class,
        IHashManager::class => HashManager::class,
        ITransactionManager::class => TransactionManager::class,

        /** DomainManagers */
        IDistanceManager::class => DistanceManager::class,
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
        $this->app->when(IFriendshipService::class)->needs(INotify::class)->give(FriendNotifier::class);
    }
}
