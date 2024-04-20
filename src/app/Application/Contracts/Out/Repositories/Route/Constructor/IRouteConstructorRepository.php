<?php

namespace App\Application\Contracts\Out\Repositories\Route\Constructor;

use App\Application\DTO\In\Route\Constructor\RouteConstructorDto;
use App\Application\Exceptions\Route\Constructor\InvalidRoutePointIndex;
use App\Infrastructure\Database\Models\RouteConstructor;
use Throwable;

interface IRouteConstructorRepository
{
    /**
     * @param RouteConstructorDto $routeConstructorDto
     * @return RouteConstructor
     * @throws InvalidRoutePointIndex
     * @throws Throwable
     */
    public function change(RouteConstructorDto $routeConstructorDto): RouteConstructor;

    /**
     * @param int $userId
     * @return RouteConstructor
     */
    public function get(int $userId): RouteConstructor;
}
