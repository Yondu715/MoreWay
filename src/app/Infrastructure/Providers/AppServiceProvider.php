<?php

namespace App\Infrastructure\Database\Models\Infrastructure\Database\Models\Infrastructure\Providers;

use App\Infrastructure\Database\Models\Infrastructure\Database\Models\Application\Contracts\In\Services\Auth\IAuthService;
use App\Infrastructure\Database\Models\Infrastructure\Database\Models\Application\Contracts\In\Services\Friend\IFriendshipService;
use App\Infrastructure\Database\Models\Infrastructure\Database\Models\Application\Contracts\In\Services\Place\Filter\IPlaceFilterService;
use App\Infrastructure\Database\Models\Infrastructure\Database\Models\Application\Contracts\In\Services\Place\IPlaceService;
use App\Infrastructure\Database\Models\Infrastructure\Database\Models\Application\Contracts\In\Services\Place\Review\IPlaceReviewService;
use App\Infrastructure\Database\Models\Infrastructure\Database\Models\Application\Contracts\In\Services\Route\IRouteService;
use App\Infrastructure\Database\Models\Infrastructure\Database\Models\Application\Contracts\In\Services\Route\Review\IRouteReviewService;
use App\Infrastructure\Database\Models\Infrastructure\Database\Models\Application\Contracts\In\Services\User\IUserService;
use App\Infrastructure\Database\Models\Infrastructure\Database\Models\Application\Contracts\Out\Managers\Cache\ICacheManager;
use App\Infrastructure\Database\Models\Infrastructure\Database\Models\Application\Contracts\Out\Managers\Hash\IHashManager;
use App\Infrastructure\Database\Models\Infrastructure\Database\Models\Application\Contracts\Out\Managers\Mail\IMailManager;
use App\Infrastructure\Database\Models\Infrastructure\Database\Models\Application\Contracts\Out\Managers\Notifier\INotifierManager;
use App\Infrastructure\Database\Models\Infrastructure\Database\Models\Application\Contracts\Out\Managers\Storage\IStorageManager;
use App\Infrastructure\Database\Models\Infrastructure\Database\Models\Application\Contracts\Out\Managers\Token\ITokenManager;
use App\Infrastructure\Database\Models\Infrastructure\Database\Models\Application\Contracts\Out\Repositories\Friend\IFriendshipRepository;
use App\Infrastructure\Database\Models\Infrastructure\Database\Models\Application\Contracts\Out\Repositories\Place\IPlaceRepository;
use App\Infrastructure\Database\Models\Infrastructure\Database\Models\Application\Contracts\Out\Repositories\Place\Locality\ILocalityRepository;
use App\Infrastructure\Database\Models\Infrastructure\Database\Models\Application\Contracts\Out\Repositories\Place\Review\IPlaceReviewRepository;
use App\Infrastructure\Database\Models\Infrastructure\Database\Models\Application\Contracts\Out\Repositories\Place\Type\IPlaceTypeRepository;
use App\Infrastructure\Database\Models\Infrastructure\Database\Models\Application\Contracts\Out\Repositories\Route\IRouteRepository;
use App\Infrastructure\Database\Models\Infrastructure\Database\Models\Application\Contracts\Out\Repositories\Route\Review\IRouteReviewRepository;
use App\Infrastructure\Database\Models\Infrastructure\Database\Models\Application\Contracts\Out\Repositories\User\IUserRepository;
use App\Infrastructure\Database\Models\Infrastructure\Database\Models\Application\Services\Auth\AuthService;
use App\Infrastructure\Database\Models\Infrastructure\Database\Models\Application\Services\Friend\FriendshipService;
use App\Infrastructure\Database\Models\Infrastructure\Database\Models\Application\Services\Place\Filter\PlaceFilterService;
use App\Infrastructure\Database\Models\Infrastructure\Database\Models\Application\Services\Place\PlaceService;
use App\Infrastructure\Database\Models\Infrastructure\Database\Models\Application\Services\Place\Review\PlaceReviewService;
use App\Infrastructure\Database\Models\Infrastructure\Database\Models\Application\Services\Route\Review\RouteReviewService;
use App\Infrastructure\Database\Models\Infrastructure\Database\Models\Application\Services\Route\RouteService;
use App\Infrastructure\Database\Models\Infrastructure\Database\Models\Application\Services\User\UserService;
use App\Infrastructure\Database\Models\Infrastructure\Database\Models\Domain\Contracts\In\DomainManagers\IDistanceManager;
use App\Infrastructure\Database\Models\Infrastructure\Database\Models\Domain\Managers\Distance\DistanceManager;
use App\Infrastructure\Database\Models\Infrastructure\Database\Models\Infrastructure\Database\Repositories\Friend\FriendshipRepository;
use App\Infrastructure\Database\Models\Infrastructure\Database\Models\Infrastructure\Database\Repositories\Place\Locality\LocalityRepository;
use App\Infrastructure\Database\Models\Infrastructure\Database\Models\Infrastructure\Database\Repositories\Place\PlaceRepository;
use App\Infrastructure\Database\Models\Infrastructure\Database\Models\Infrastructure\Database\Repositories\Place\Review\PlaceReviewRepository;
use App\Infrastructure\Database\Models\Infrastructure\Database\Models\Infrastructure\Database\Repositories\Place\Type\PlaceTypeRepository;
use App\Infrastructure\Database\Models\Infrastructure\Database\Models\Infrastructure\Database\Repositories\Route\Review\RouteReviewRepository;
use App\Infrastructure\Database\Models\Infrastructure\Database\Models\Infrastructure\Database\Repositories\Route\RouteRepository;
use App\Infrastructure\Database\Models\Infrastructure\Database\Models\Infrastructure\Database\Repositories\User\UserRepository;
use App\Infrastructure\Database\Models\Infrastructure\Database\Models\Infrastructure\Database\Transaction\Interface\ITransactionManager;
use App\Infrastructure\Database\Models\Infrastructure\Database\Models\Infrastructure\Database\Transaction\TransactionManager;
use App\Infrastructure\Database\Models\Infrastructure\Database\Models\Infrastructure\Managers\Cache\CacheManager;
use App\Infrastructure\Database\Models\Infrastructure\Database\Models\Infrastructure\Managers\Hash\HashManager;
use App\Infrastructure\Database\Models\Infrastructure\Database\Models\Infrastructure\Managers\Mail\MailManager;
use App\Infrastructure\Database\Models\Infrastructure\Database\Models\Infrastructure\Managers\Storage\StorageManager;
use App\Infrastructure\Database\Models\Infrastructure\Database\Models\Infrastructure\Managers\Token\TokenManager;
use App\Infrastructure\Database\Models\Infrastructure\Database\Models\Infrastructure\WebSocket\Controllers\Friend\FriendNotifier;
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
        IRouteReviewService::class => RouteReviewService::class,
        IPlaceFilterService::class => PlaceFilterService::class,

        /** REPOSITORIES */
        IUserRepository::class => UserRepository::class,
        IPlaceRepository::class => PlaceRepository::class,
        IPlaceReviewRepository::class => PlaceReviewRepository::class,
        IFriendshipRepository::class => FriendshipRepository::class,
        IRouteRepository::class => RouteRepository::class,
        IRouteReviewRepository::class => RouteReviewRepository::class,
        ILocalityRepository::class => LocalityRepository::class,
        IPlaceTypeRepository::class => PlaceTypeRepository::class,

        /** InfrastructureManagers */
        ITokenManager::class => TokenManager::class,
        IStorageManager::class => StorageManager::class,
        ICacheManager::class => CacheManager::class,
        IMailManager::class => MailManager::class,
        IHashManager::class => HashManager::class,
        ITransactionManager::class => TransactionManager::class,
        INotifierManager::class => FriendNotifier::class,

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
        // $this->app->when(IFriendshipService::class)->needs(INotifierManager::class)->give(FriendNotifier::class);
    }
}
