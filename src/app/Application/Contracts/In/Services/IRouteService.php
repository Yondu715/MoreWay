<?php

namespace App\Application\Contracts\In\Services;

use App\Application\DTO\In\Route\CreateRouteDto;
use App\Application\DTO\Out\Route\RouteDto;
use App\Application\Exceptions\Route\FailedToCreateRoute;

interface IRouteService
{
    /**
     * @param CreateRouteDto $createRouteDto
     * @return RouteDto
     * @throws FailedToCreateRoute
     */
    public function createRoute(CreateRouteDto $createRouteDto): RouteDto;
}
