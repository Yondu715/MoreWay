<?php

namespace App\Application\Contracts\Out\Repositories\Route\Constructor;

use App\Application\DTO\In\Route\Constructor\ChangeUserRouteConstructorDto;
use App\Application\DTO\Out\Route\Constructor\RouteConstructorDto;
use App\Application\Exceptions\Route\Constructor\InvalidRoutePointIndex;
use Closure;

interface IRouteConstructorRepository
{
    /**
     * @param ChangeUserRouteConstructorDto $changeUserRouteConstructorDto
     * @param Closure $distanceCalculator
     * @return RouteConstructorDto
     * @throws InvalidRoutePointIndex
     */
    public function update(ChangeUserRouteConstructorDto $changeUserRouteConstructorDto, Closure $distanceCalculator): RouteConstructorDto;

    /**
     * @param int $userId
     * @param ?Closure $distanceCalculator
     * @return RouteConstructorDto
     */
    public function findByUserId(int $userId, ?Closure $distanceCalculator = null): RouteConstructorDto;
}
