<?php

namespace App\Application\Contracts\In\Services\Route\Constructor;

use App\Application\DTO\In\Route\Constructor\RouteConstructorDto as InRouteConstructorDto;
use App\Application\DTO\Out\Route\Constructor\RouteConstructorDto as OutRouteConstructorDto;
use App\Application\Exceptions\Route\Constructor\InvalidRoutePointIndex;
use Throwable;

interface IRouteConstructorService
{
    /**
     * @param InRouteConstructorDto $routeConstructorDto
     * * @return OutRouteConstructorDto
     * * @throws InvalidRoutePointIndex
     * * @throws Throwable
     */
    public function change(InRouteConstructorDto $routeConstructorDto): OutRouteConstructorDto;

    /**
     * @param int $userId
     * @return OutRouteConstructorDto
     */
    public function get(int $userId): OutRouteConstructorDto;
}
