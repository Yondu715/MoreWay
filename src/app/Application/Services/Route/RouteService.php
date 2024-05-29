<?php

namespace App\Application\Services\Route;

use App\Application\Contracts\In\Services\Route\IRouteService;
use App\Application\Contracts\Out\Repositories\Route\IRouteRepository;
use App\Application\DTO\Collection\CursorDto;
use App\Application\DTO\In\Route\ChangeUserRouteDto;
use App\Application\DTO\In\Route\CompletedRoutePointDto;
use App\Application\DTO\In\Route\CreateRouteDto;
use App\Application\DTO\In\Route\GetRoutesDto;
use App\Application\DTO\In\Route\GetUserRoutesDto;
use App\Application\DTO\Out\Route\ActiveRouteDto;
use App\Application\DTO\Out\Route\RouteDto;
use App\Application\Exceptions\Route\FailedToCreateRoute;
use App\Application\Exceptions\Route\IncorrectOrderRoutePoints;
use App\Application\Exceptions\Route\RouteIsCompleted;
use App\Application\Exceptions\Route\RouteNameIsTaken;
use App\Application\Exceptions\Route\UserHaveNotActiveRoute;
use App\Application\Exceptions\Route\UserRouteProgressNotFound;


class RouteService implements IRouteService
{
    public function __construct(
        private readonly IRouteRepository $routeRepository
    ) {}

    /**
     * @param CreateRouteDto $createRouteDto
     * @return RouteDto
     * @throws RouteNameIsTaken
     * @throws FailedToCreateRoute
     */
    public function createRoute(CreateRouteDto $createRouteDto): RouteDto
    {
        if($this->routeRepository->isExistByName($createRouteDto->name)) {
            throw new RouteNameIsTaken();
        }
        return $this->routeRepository->create($createRouteDto);
    }

    /**
     * @param int $routeId
     * @return RouteDto
     */
    public function getRouteById(int $routeId): RouteDto
    {
        return $this->routeRepository->getRouteById($routeId);
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
     */
    public function completedRoutePoint(CompletedRoutePointDto $completedRoutePointDto): void
    {
        $this->routeRepository->changeUserRouteProgress($completedRoutePointDto);
    }

    /**
     * @param GetUserRoutesDto $getUserRoutesDto
     * @return CursorDto
     */
    public function getUsersRoutes(GetUserRoutesDto $getUserRoutesDto): CursorDto
    {
        return $this->routeRepository->getUsersRoutes($getUserRoutesDto);
    }

    /**
     * @param int $userId
     * @param int $routeId
     * @return void
     */
    public function deleteUserRoute(int $userId, int $routeId): void
    {
        $this->routeRepository->deleteUserRoute($userId, $routeId);
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
        return $this->routeRepository->changeActiveUserRoute($changeActiveUserRouteDto);
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
        return  $this->routeRepository->addRouteToUserFavorite($changeUserRouteDto);
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
