<?php

namespace App\Application\Contracts\In\Services\Route;

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

interface IRouteService
{
    /**
     * @param CreateRouteDto $createRouteDto
     * @return RouteDto
     * @throws FailedToCreateRoute
     */
    public function createRoute(CreateRouteDto $createRouteDto): RouteDto;

    /**
     * @param int $routeId
     * @return RouteDto
     */
    public function getRouteById(int $routeId): RouteDto;

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
     */
    public function completedRoutePoint(CompletedRoutePointDto $completedRoutePointDto): void;

    /**
     * @param GetUserRoutesDto $getUserRoutesDto
     * @return CursorDto
     */
    public function getUsersRoutes(GetUserRoutesDto $getUserRoutesDto): CursorDto;

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
     * @param ChangeUserRouteDto $changeActiveUserRouteDto
     * @return ActiveRouteDto
     * @throws RouteIsCompleted
     */
    public function changeActiveUserRoute(ChangeUserRouteDto $changeActiveUserRouteDto): ActiveRouteDto;

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
}
