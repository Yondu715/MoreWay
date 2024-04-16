<?php

namespace App\Infrastructure\Database\Models\Infrastructure\Database\Models\Application\Contracts\In\Services\Route;

use App\Infrastructure\Database\Models\Infrastructure\Database\Models\Application\DTO\In\Route\CreateRouteDto;
use App\Infrastructure\Database\Models\Infrastructure\Database\Models\Application\DTO\Out\Route\RouteDto;
use App\Infrastructure\Database\Models\Infrastructure\Database\Models\Application\Exceptions\Route\FailedToCreateRoute;
use App\Infrastructure\Database\Models\Infrastructure\Database\Models\Application\Exceptions\Route\RouteNotFound;

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
}
