<?php

namespace App\Application\Contracts\Out\Repositories\Route;

use App\Application\DTO\In\Route\CreateRouteDto;
use App\Application\Exceptions\Route\FailedToCreateRoute;
use App\Application\Exceptions\Route\RouteNotFound;
use App\Infrastructure\Database\Models\Route;

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
