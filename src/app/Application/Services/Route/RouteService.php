<?php

namespace App\Application\Services\Route;

use App\Application\DTO\Out\Route\RouteDto;
use App\Application\DTO\Collection\CursorDto;
use App\Utils\Mappers\Out\Vote\VoteDtoMapper;
use App\Application\DTO\In\Route\GetRoutesDto;
use App\Infrastructure\Exceptions\InvalidToken;
use App\Application\DTO\In\Route\CreateRouteDto;
use App\Application\DTO\Out\Route\ActiveRouteDto;
use App\Application\Enums\Route\RouteRestriction;
use App\Application\Exceptions\Chat\ChatNotFound;
use App\Application\DTO\In\Route\GetUserRoutesDto;
use App\Application\Exceptions\Route\RouteNotFound;
use App\Application\DTO\In\Route\ChangeUserRouteDto;
use App\Application\Exceptions\Route\RouteIsCompleted;
use App\Application\Exceptions\Route\RouteNameIsTaken;
use App\Application\DTO\In\Route\CompletedRoutePointDto;
use App\Application\Exceptions\Route\ExceededCountItems;
use App\Application\Exceptions\Route\FailedToCreateRoute;
use App\Application\Exceptions\Route\UserHaveNotActiveRoute;
use App\Domain\Contracts\In\DomainManagers\IDistanceManager;
use App\Application\Exceptions\Route\Point\ExceedingDistance;
use App\Infrastructure\Http\Resources\Chat\Vote\VoteResource;
use App\Application\Contracts\In\Services\Route\IRouteService;
use App\Application\Exceptions\Route\Point\RoutePointNotFound;
use App\Application\Contracts\Out\Managers\Cache\ICacheManager;
use App\Application\Contracts\Out\Managers\Token\ITokenManager;
use App\Application\Exceptions\Route\IncorrectOrderRoutePoints;
use App\Application\Exceptions\Route\UserRouteProgressNotFound;
use App\Application\Contracts\Out\Repositories\Chat\IChatRepository;
use App\Application\Contracts\Out\Managers\Notifier\INotifierManager;
use App\Application\Contracts\Out\Repositories\Route\IRouteRepository;
use App\Application\Contracts\Out\Repositories\Route\Constructor\IRouteConstructorRepository;
use App\Application\Exceptions\Route\MissingCountItems;

class RouteService implements IRouteService
{
    public function __construct(
        private readonly IRouteRepository $routeRepository,
        private readonly IChatRepository $chatRepository,
        private readonly IRouteConstructorRepository $routeConstructorRepository,
        private readonly ITokenManager $tokenManager,
        private readonly IDistanceManager $distanceManager,
        private readonly ICacheManager $cacheManager,
        private readonly INotifierManager $notifier
    ) {
    }

    /**
     * @param CreateRouteDto $createRouteDto
     * @return RouteDto
     * @throws RouteNameIsTaken
     * @throws FailedToCreateRoute
     */
    public function createRoute(CreateRouteDto $createRouteDto): RouteDto
    {
        if ($this->routeRepository->isExistByName($createRouteDto->name)) {
            throw new RouteNameIsTaken();
        }

        $constructor = $this->routeConstructorRepository->findByUserId($createRouteDto->userId);

        if (count($constructor->points) < RouteRestriction::MIN_ROUTE_ITEMS->value) {
            throw new MissingCountItems();
        }
        
        if (count($constructor->points) > RouteRestriction::MAX_ROUTE_ITEMS->value) {
            throw new ExceededCountItems();
        }

        return $this->routeRepository->create($createRouteDto);
    }

    /**
     * @param int $routeId
     * @return RouteDto
     * @throws InvalidToken
     * @throws RouteNotFound
     */
    public function getRouteById(int $routeId): RouteDto
    {
        return $this->routeRepository->getRouteById($routeId, $this->tokenManager->getAuthUser()->user->id);
    }

    /**
     * @param GetRoutesDto $getRoutesDto
     * @return CursorDto
     */
    public function getRoutes(GetRoutesDto $getRoutesDto): CursorDto
    {
        return $this->routeRepository->getRoutes($getRoutesDto);
    }

    /**
     * @param CompletedRoutePointDto $completedRoutePointDto
     * @return void
     * @throws UserRouteProgressNotFound
     * @throws IncorrectOrderRoutePoints
     * @throws RouteNameIsTaken
     * @throws RouteNotFound
     * @throws RoutePointNotFound
     * @throws ExceedingDistance
     * @throws ChatNotFound
     */
    public function completedRoutePoint(CompletedRoutePointDto $completedRoutePointDto): void
    {
        $routePoint = $this->routeRepository->getRoutePointById($completedRoutePointDto->routePointId);

        if ($this->distanceManager->calculate(
            $routePoint->place->lat,
            $routePoint->place->lon,
            $completedRoutePointDto->lat,
            $completedRoutePointDto->lon
        ) * 1000 > 300000) {
            throw new ExceedingDistance();
        }

        $activeRoute = $this->routeRepository
            ->getActiveRouteByRoutePointIdAndUserId(
                $completedRoutePointDto->routePointId,
                $completedRoutePointDto->userId
            );

        if (!$activeRoute->isGroup) {
            $this->routeRepository->changeUserRouteProgress($completedRoutePointDto);
            return;
        }

        $activeChat = $this->chatRepository->getUserActiveChat($completedRoutePointDto->userId);

        $cacheKey = "ChangeRoutePointByChatId-{$activeChat->id}";

        $membersIdInHolding = json_decode($this->cacheManager->get($cacheKey)) ?
            json_decode($this->cacheManager->get($cacheKey)) : [];

        if (
            !in_array($completedRoutePointDto->userId, $membersIdInHolding)
            and count($membersIdInHolding) < $activeChat->members->count()
        ) {
            $membersIdInHolding[] = $completedRoutePointDto->userId;
            $this->cacheManager->put($cacheKey, json_encode($membersIdInHolding), 10);
            foreach ($activeChat->members as $member) {
                $this->notifier->sendNotification($member->id, VoteResource::make(VoteDtoMapper::fromAllAndAccepted(
                    $activeChat->members,
                    $activeChat->members->whereIn('id', $membersIdInHolding)
                )));
            }
            if (count($membersIdInHolding) === $activeChat->members->count()) {
                $this->cacheManager->delete($cacheKey);
                foreach ($membersIdInHolding as $memberId) {
                    $completedRoutePointDto->userId = $memberId;
                    $this->routeRepository->changeUserRouteProgress($completedRoutePointDto);
                }
            }
        }
    }

    /**
     * @param GetUserRoutesDto $getUserRoutesDto
     * @return CursorDto
     */
    public function getUserRoutes(GetUserRoutesDto $getUserRoutesDto): CursorDto
    {
        return $this->routeRepository->getUserRoutes($getUserRoutesDto);
    }

    /**
     * @param int $userId
     * @param int $routeId
     * @return void
     */
    public function deleteUserRoute(int $userId, int $routeId): void
    {
        $this->routeRepository->deleteRouteByRouteIdAndCreatorId($routeId, $userId);
    }

    /**
     * @param int $userId
     * @return ActiveRouteDto
     * @throws UserHaveNotActiveRoute
     */
    public function getActiveUserRoute(int $userId): ActiveRouteDto
    {
        return $this->routeRepository->getActiveUserRoute($userId);
    }

    /**
     * @param ChangeUserRouteDto $changeActiveUserRouteDto
     * @return ActiveRouteDto
     * @throws RouteIsCompleted
     */
    public function changeActiveUserRoute(ChangeUserRouteDto $changeActiveUserRouteDto): ActiveRouteDto
    {
        return $this->routeRepository
            ->changeActiveUserRoute(
                $changeActiveUserRouteDto->userId,
                $changeActiveUserRouteDto->routeId,
                false
            );
    }

    /**
     * @param GetUserRoutesDto $getUserRoutesDto
     * @return CursorDto
     */
    public function getFavoriteUserRoutes(GetUserRoutesDto $getUserRoutesDto): CursorDto
    {
        return $this->routeRepository->getFavoriteUserRoutes($getUserRoutesDto);
    }

    /**
     * @param ChangeUserRouteDto $changeUserRouteDto
     * @return RouteDto
     */
    public function addRouteToUserFavorite(ChangeUserRouteDto $changeUserRouteDto): RouteDto
    {
        return  $this->routeRepository->addRouteToUserFavorite($changeUserRouteDto->userId, $changeUserRouteDto->routeId);
    }

    /**
     * @param int $userId
     * @param int $routeId
     * @return void
     */
    public function deleteRouteFromUserFavorite(int $userId, int $routeId): void
    {
        $this->routeRepository->deleteRouteFromUserFavorite($userId, $routeId);
    }
}
