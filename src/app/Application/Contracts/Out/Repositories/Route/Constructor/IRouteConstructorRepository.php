<?php

namespace App\Application\Contracts\Out\Repositories\Route\Constructor;

use App\Application\DTO\In\Route\Constructor\ChangeUserRouteConstructorDto;
use App\Application\DTO\In\Route\Constructor\GetUserRouteConstructorDto;
use App\Application\DTO\Out\Route\Constructor\RouteConstructorDto;
use App\Application\Exceptions\Route\Constructor\InvalidRoutePointIndex;
use Closure;
use Throwable;

interface IRouteConstructorRepository
{
    /**
     * @param ChangeUserRouteConstructorDto $changeUserRouteConstructorDto
     * @param Closure $distanceCalculator
     * @return RouteConstructorDto
     * @throws InvalidRoutePointIndex
     * @throws Throwable
     */
    public function update(ChangeUserRouteConstructorDto $changeUserRouteConstructorDto, Closure $distanceCalculator): RouteConstructorDto;

    /**
     * @param GetUserRouteConstructorDto $getUserRouteConstructorDto
     * @param Closure $distanceCalculator
     * @return RouteConstructorDto
     */
    public function findByUserId(GetUserRouteConstructorDto $getUserRouteConstructorDto, Closure $distanceCalculator): RouteConstructorDto;
}
