<?php

namespace App\Application\Contracts\In\Services\Route\Constructor;

use App\Application\DTO\In\Route\Constructor\ChangeUserRouteConstructorDto;
use App\Application\DTO\In\Route\Constructor\GetUserRouteConstructorDto;
use App\Application\DTO\Out\Route\Constructor\RouteConstructorDto;
use App\Application\Exceptions\Route\Constructor\InvalidRoutePointIndex;

interface IRouteConstructorService
{
    /**
     * @param ChangeUserRouteConstructorDto $changeUserRouteConstructorDto
     * * @return RouteConstructorDto
     * * @throws InvalidRoutePointIndex
     */
    public function change(ChangeUserRouteConstructorDto $changeUserRouteConstructorDto): RouteConstructorDto;

    /**
     * @param GetUserRouteConstructorDto $getUserRouteConstructorDto
     * @return RouteConstructorDto
     */
    public function get(GetUserRouteConstructorDto $getUserRouteConstructorDto): RouteConstructorDto;
}
