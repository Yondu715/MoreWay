<?php

namespace App\Application\Contracts\Out\Repositories\Route;

use App\Application\DTO\In\Route\ChangeActiveUserRouteDto;
use App\Application\DTO\In\Route\CompletedRoutePointDto;
use App\Application\DTO\In\Route\CreateRouteDto;
use App\Application\DTO\In\Route\GetRoutesDto;
use App\Application\DTO\In\Route\GetUserRoutesDto;
use App\Application\Exceptions\Route\FailedToCreateRoute;
use App\Application\Exceptions\Route\IncorrectOrderRoutePoints;
use App\Application\Exceptions\Route\RouteIsCompleted;
use App\Application\Exceptions\Route\RouteNotFound;
use App\Application\Exceptions\Route\UserHaveNotActiveRoute;
use App\Application\Exceptions\Route\UserRouteProgressNotFound;
use App\Infrastructure\Database\Models\Route;
use App\Infrastructure\Database\Models\UserActiveRoute;
use Illuminate\Contracts\Pagination\CursorPaginator;

interface IRouteRepository
{
    /**
     * @param CreateRouteDto $createRouteDto
     * @return Route
     * @throws FailedToCreateRoute
     */
    public function create(CreateRouteDto $createRouteDto):Route;

    /**
     * @param int $routeId
     * @return Route
     * @throws RouteNotFound
     */
    public function getRouteById(int $routeId): Route;

    /**
     * @param GetRoutesDto $getRoutesDto
     * @return CursorPaginator
     * @throws RouteNotFound
     */
    public function getRoutes(GetRoutesDto $getRoutesDto): CursorPaginator;

    /**
     * @param CompletedRoutePointDto $completedRoutePointDto
     * @return void
     * @throws UserRouteProgressNotFound
     * @throws IncorrectOrderRoutePoints
     * @throws RouteNotFound
     */
    public function changeUserRouteProgress(CompletedRoutePointDto $completedRoutePointDto): void;

    /**
     * @param GetUserRoutesDto $getUserRoutesDto
     * @return CursorPaginator
     */
    public function getUsersRoutes(GetUserRoutesDto $getUserRoutesDto): CursorPaginator;

    /**
     * @param int $userId
     * @param int $routeId
     * @return void
     * @throws RouteNotFound
     */
    public function deleteUserRoute(int $userId, int $routeId): void;

    /**
     * @param int $userId
     * @return UserActiveRoute
     * @throws UserHaveNotActiveRoute
     */
    public function getActiveUserRoute(int $userId): UserActiveRoute;

    /**
     * @param ChangeActiveUserRouteDto $changeActiveUserRouteDto
     * @return UserActiveRoute
     * @throws RouteIsCompleted
     */
    public function changeActiveUserRoute(ChangeActiveUserRouteDto $changeActiveUserRouteDto): UserActiveRoute;
}
