<?php

namespace App\Application\Contracts\Out\Repositories\Route\Constructor;

use App\Application\DTO\In\Route\Constructor\RouteConstructorDto as InRouteConstructorDto;
use App\Application\DTO\Out\Route\Constructor\RouteConstructorDto as OutRouteConstructorDto;
use App\Application\Exceptions\Route\Constructor\InvalidRoutePointIndex;
use Throwable;

interface IRouteConstructorRepository
{
    /**
     * @param RouteConstructorDto $routeConstructorDto
     * @return OutRouteConstructorDto
     * @throws InvalidRoutePointIndex
     * @throws Throwable
     */
    public function update(InRouteConstructorDto $routeConstructorDto): OutRouteConstructorDto;

    /**
     * @param int $userId
     * @return OutRouteConstructorDto
     */
    public function findByUserId(int $userId): OutRouteConstructorDto;
}
