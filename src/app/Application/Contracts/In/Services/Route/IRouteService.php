<?php

namespace App\Application\Contracts\In\Services\Route;

use App\Application\DTO\Collection\CursorDto;
use App\Application\DTO\In\Route\CreateRouteDto;
use App\Application\DTO\In\Route\GetRoutesDto;
use App\Application\DTO\Out\Route\RouteDto;
use App\Application\Exceptions\Route\FailedToCreateRoute;
use App\Application\Exceptions\Route\RouteNotFound;

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
     * @throws RouteNotFound
     */
    public function getRouteById(int $routeId): RouteDto;

    /**
     * @param GetRoutesDto $getRoutesDto
     * @return CursorDto
     * @throws RouteNotFound
     */
    public function getRoutes(GetRoutesDto $getRoutesDto): CursorDto;
}
