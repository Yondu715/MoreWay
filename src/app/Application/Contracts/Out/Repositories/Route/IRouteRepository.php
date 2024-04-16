<?php

namespace App\Infrastructure\Database\Models\Infrastructure\Database\Models\Application\Contracts\Out\Repositories\Route;

use App\Infrastructure\Database\Models\Infrastructure\Database\Models\Application\DTO\In\Route\CreateRouteDto;
use App\Infrastructure\Database\Models\Infrastructure\Database\Models\Application\Exceptions\Route\FailedToCreateRoute;
use App\Infrastructure\Database\Models\Infrastructure\Database\Models\Application\Exceptions\Route\RouteNotFound;
use App\Infrastructure\Database\Models\Infrastructure\Database\Models\Infrastructure\Database\Models\Route;

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
    public function findById(int $routeId): Route;
}
