<?php

namespace App\Application\Contracts\Out\Repositories\Route;

use App\Application\DTO\Collection\CursorDto;
use App\Application\DTO\In\Route\ChangeUserRouteDto;
use App\Application\DTO\In\Route\CompletedRoutePointDto;
use App\Application\DTO\In\Route\CreateRouteDto;
use App\Application\DTO\In\Route\GetRoutesDto;
use App\Application\DTO\In\Route\GetUserRoutesDto;
use App\Application\DTO\Out\Route\ActiveRouteDto;
use App\Application\DTO\Out\Route\Point\PointDto;
use App\Application\DTO\Out\Route\RouteDto;
use App\Application\Exceptions\Route\FailedToCreateRoute;
use App\Application\Exceptions\Route\IncorrectOrderRoutePoints;
use App\Application\Exceptions\Route\Point\RoutePointNotFound;
use App\Application\Exceptions\Route\RouteIsCompleted;
use App\Application\Exceptions\Route\RouteNameIsTaken;
use App\Application\Exceptions\Route\RouteNotFound;
use App\Application\Exceptions\Route\UserHaveNotActiveRoute;
use App\Application\Exceptions\Route\UserRouteProgressNotFound;

interface IRouteRepository
{
    /**
     * @param CreateRouteDto $createRouteDto
     * @return RouteDto
     * @throws FailedToCreateRoute
     */
    public function create(CreateRouteDto $createRouteDto): RouteDto;

    /**
     * @param int $routeId
     * @param int $userId
     * @return RouteDto
     * @throws RouteNotFound
     */
    public function getRouteById(int $routeId, int $userId): RouteDto;

    /**
     * @param int $routePointId
     * @param int $userId
     * @return ActiveRouteDto
     * @throws RouteNotFound
     */
    public function getActiveRouteByRoutePointIdAndUserId(int $routePointId, int $userId): ActiveRouteDto;

    /**
     * @param int $routePointId
     * @return PointDto
     * @throws RoutePointNotFound
     */
    public function getRoutePointById(int $routePointId): PointDto;

    /**
     * @param GetRoutesDto $getRoutesDto
     * @return CursorDto
     */
    public function getRoutes(GetRoutesDto $getRoutesDto): CursorDto;

    /**
     * @param CompletedRoutePointDto $completedRoutePointDto
     * @return void
     * @throws UserRouteProgressNotFound
     * @throws IncorrectOrderRoutePoints
     * @throws RouteNameIsTaken
     */
    public function changeUserRouteProgress(CompletedRoutePointDto $completedRoutePointDto): void;

    /**
     * @param GetUserRoutesDto $getUserRoutesDto
     * @return CursorDto
     */
    public function getUserRoutes(GetUserRoutesDto $getUserRoutesDto): CursorDto;

    /**
     * @param int $userId
     * @param int $routeId
     * @return void
     */
    public function deleteUserRoute(int $userId, int $routeId): void;

    /**
     * @param int $userId
     * @return ActiveRouteDto
     * @throws UserHaveNotActiveRoute
     */
    public function getActiveUserRoute(int $userId): ActiveRouteDto;

    /**
     * @param int $userId
     * @param int $routeId
     * @param bool $isGroup
     * @return ActiveRouteDto
     * @throws RouteIsCompleted
     */
    public function changeActiveUserRoute(int $userId, int $routeId, bool $isGroup): ActiveRouteDto;

    /**
     * @param GetUserRoutesDto $getUserRoutesDto
     * @return CursorDto
     */
    public function getFavoriteUserRoutes(GetUserRoutesDto $getUserRoutesDto): CursorDto;

    /**
     * @param ChangeUserRouteDto $changeUserRouteDto
     * @return RouteDto
     */
    public function addRouteToUserFavorite(ChangeUserRouteDto $changeUserRouteDto): RouteDto;

    /**
     * @param int $userId
     * @param int $routeId
     * @return void
     */
    public function deleteRouteFromUserFavorite(int $userId, int $routeId): void;

    /**
     * @param string $routeName
     * @return bool
     */
    public function isExistByName(string $routeName): bool;
}
