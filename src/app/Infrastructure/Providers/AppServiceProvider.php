<?php

namespace App\Infrastructure\Providers;

use App\Application\Contracts\In\Services\Achievement\IAchievementService;
use App\Application\Contracts\In\Services\Auth\IAuthService;
use App\Application\Contracts\In\Services\Chat\Activity\IChatActivityService;
use App\Application\Contracts\In\Services\Chat\IChatService;
use App\Application\Contracts\In\Services\Chat\Member\IChatMemberService;
use App\Application\Contracts\In\Services\Chat\Message\IMessageService;
use App\Application\Contracts\In\Services\Friend\IFriendshipService;
use App\Application\Contracts\In\Services\Place\Filter\IPlaceFilterService;
use App\Application\Contracts\In\Services\Place\IPlaceService;
use App\Application\Contracts\In\Services\Place\Review\IPlaceReviewService;
use App\Application\Contracts\In\Services\Rating\IRatingService;
use App\Application\Contracts\In\Services\Route\Constructor\IRouteConstructorService;
use App\Application\Contracts\In\Services\Route\Filter\IRouteFilterService;
use App\Application\Contracts\In\Services\Route\IRouteService;
use App\Application\Contracts\In\Services\Route\Review\IRouteReviewService;
use App\Application\Contracts\In\Services\User\IUserService;
use App\Application\Contracts\Out\Managers\Cache\ICacheManager;
use App\Application\Contracts\Out\Managers\Hash\IHashManager;
use App\Application\Contracts\Out\Managers\Mail\IMailManager;
use App\Application\Contracts\Out\Managers\Notifier\INotifierManager;
use App\Application\Contracts\Out\Managers\Storage\IStorageManager;
use App\Application\Contracts\Out\Managers\Token\ITokenManager;
use App\Application\Contracts\Out\Repositories\Achievement\IAchievementRepository;
use App\Application\Contracts\Out\Repositories\Achievement\Type\IAchievementTypeRepository;
use App\Application\Contracts\Out\Repositories\Chat\IChatRepository;
use App\Application\Contracts\Out\Repositories\Chat\Message\IMessageRepository;
use App\Application\Contracts\Out\Repositories\Friend\IFriendshipRepository;
use App\Application\Contracts\Out\Repositories\Place\IPlaceRepository;
use App\Application\Contracts\Out\Repositories\Place\Locality\ILocalityRepository;
use App\Application\Contracts\Out\Repositories\Place\Review\IPlaceReviewRepository;
use App\Application\Contracts\Out\Repositories\Place\Type\IPlaceTypeRepository;
use App\Application\Contracts\Out\Repositories\Rating\IRatingRepository;
use App\Application\Contracts\Out\Repositories\Route\Constructor\IRouteConstructorRepository;
use App\Application\Contracts\Out\Repositories\Route\IRouteRepository;
use App\Application\Contracts\Out\Repositories\Route\Review\IRouteReviewRepository;
use App\Application\Contracts\Out\Repositories\User\IUserRepository;
use App\Application\Services\Achievement\AchievementService;
use App\Application\Services\Auth\AuthService;
use App\Application\Services\Chat\Activity\ChatActivityService;
use App\Application\Services\Chat\ChatService;
use App\Application\Services\Chat\Member\ChatMemberService;
use App\Application\Services\Chat\Message\MessageService;
use App\Application\Services\Friend\FriendshipService;
use App\Application\Services\Place\Filter\PlaceFilterService;
use App\Application\Services\Place\PlaceService;
use App\Application\Services\Place\Review\PlaceReviewService;
use App\Application\Services\Rating\RatingService;
use App\Application\Services\Route\Constructor\RouteConstructorService;
use App\Application\Services\Route\Filter\RouteFilterService;
use App\Application\Services\Route\Review\RouteReviewService;
use App\Application\Services\Route\RouteService;
use App\Application\Services\User\UserService;
use App\Infrastructure\Database\Repositories\Achievement\AchievementRepository;
use App\Infrastructure\Database\Repositories\Achievement\Type\AchievementTypeRepository;
use App\Infrastructure\Database\Repositories\Chat\ChatRepository;
use App\Infrastructure\Database\Repositories\Chat\Message\MessageRepository;
use App\Infrastructure\Database\Repositories\Friend\FriendshipRepository;
use App\Infrastructure\Database\Repositories\Place\Locality\LocalityRepository;
use App\Infrastructure\Database\Repositories\Place\PlaceRepository;
use App\Infrastructure\Database\Repositories\Place\Review\PlaceReviewRepository;
use App\Infrastructure\Database\Repositories\Place\Type\PlaceTypeRepository;
use App\Infrastructure\Database\Repositories\Rating\RatingRepository;
use App\Infrastructure\Database\Repositories\Route\Constructor\RouteConstructorRepository;
use App\Infrastructure\Database\Repositories\Route\Review\RouteReviewRepository;
use App\Infrastructure\Database\Repositories\Route\RouteRepository;
use App\Infrastructure\Database\Repositories\User\UserRepository;
use App\Infrastructure\Database\Transaction\Interface\ITransactionManager;
use App\Infrastructure\Database\Transaction\TransactionManager;
use App\Infrastructure\Managers\Cache\CacheManager;
use App\Infrastructure\Managers\Hash\HashManager;
use App\Infrastructure\Managers\Mail\MailManager;
use App\Infrastructure\Managers\Storage\StorageManager;
use App\Infrastructure\Managers\Token\TokenManager;
use App\Infrastructure\WebSocket\Notifiers\Notification\Chat\Activity\ChatActivityNotifier;
use App\Infrastructure\WebSocket\Notifiers\Notification\Chat\ChatNotifier;
use App\Infrastructure\WebSocket\Notifiers\Notification\Chat\Member\ChatMemberNotifier;
use App\Infrastructure\WebSocket\Notifiers\Notification\Chat\Message\MessageNotifier;
use App\Infrastructure\WebSocket\Notifiers\Notification\Friend\FriendNotifier;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /** @var array<class-string, class-string> $bindings */
    public array $bindings = [
        /** SERVICES */
        IUserService::class => UserService::class,
        IAuthService::class => AuthService::class,
        IFriendshipService::class => FriendshipService::class,
        IPlaceService::class => PlaceService::class,
        IPlaceReviewService::class => PlaceReviewService::class,
        IPlaceFilterService::class => PlaceFilterService::class,
        IRouteService::class => RouteService::class,
        IRouteReviewService::class => RouteReviewService::class,
        IRouteFilterService::class => RouteFilterService::class,
        IRouteConstructorService::class => RouteConstructorService::class,
        IAchievementService::class => AchievementService::class,
        IRatingService::class => RatingService::class,
        IChatService::class => ChatService::class,
        IMessageService::class => MessageService::class,
        IChatActivityService::class => ChatActivityService::class,
        IChatMemberService::class => ChatMemberService::class,

        /** REPOSITORIES */
        IUserRepository::class => UserRepository::class,
        IPlaceRepository::class => PlaceRepository::class,
        IPlaceReviewRepository::class => PlaceReviewRepository::class,
        IFriendshipRepository::class => FriendshipRepository::class,
        IRouteRepository::class => RouteRepository::class,
        IRouteReviewRepository::class => RouteReviewRepository::class,
        ILocalityRepository::class => LocalityRepository::class,
        IPlaceTypeRepository::class => PlaceTypeRepository::class,
        IRouteConstructorRepository::class => RouteConstructorRepository::class,
        IAchievementRepository::class => AchievementRepository::class,
        IAchievementTypeRepository::class => AchievementTypeRepository::class,
        IRatingRepository::class => RatingRepository::class,
        IChatRepository::class => ChatRepository::class,
        IMessageRepository::class => MessageRepository::class,

        /** Managers */
        ITokenManager::class => TokenManager::class,
        IStorageManager::class => StorageManager::class,
        ICacheManager::class => CacheManager::class,
        IMailManager::class => MailManager::class,
        IHashManager::class => HashManager::class,
        ITransactionManager::class => TransactionManager::class,

    ];


    /** @var array<class-string, array<int, string>> */
    public array $whenBindings = [
        FriendshipService::class => [
            INotifierManager::class => FriendNotifier::class,
        ],
        ChatService::class => [
            INotifierManager::class => ChatNotifier::class,
        ],
        MessageService::class => [
            INotifierManager::class => MessageNotifier::class,
        ],
        ChatActivityService::class => [
            INotifierManager::class => ChatActivityNotifier::class,
        ],
        ChatMemberService::class => [
            INotifierManager::class => ChatMemberNotifier::class,
        ],
    ];

    /**
     * Register any application services.
     */
    public function register(): void
    {
        foreach ($this->whenBindings as $concrete => $bindings) {
            foreach ($bindings as $abstract => $implementation) {
                $this->app->when($concrete)
                    ->needs($abstract)
                    ->give($implementation);
            }
        }
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
    }
}
