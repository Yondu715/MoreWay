<?php

namespace App\Utils\Mappers\Out\Route\Constructor;

use App\Application\DTO\Out\Route\Constructor\RouteConstructorDto;
use App\Infrastructure\Database\Models\RouteConstructor;
use App\Utils\Mappers\Out\Route\Point\PointDtoMapper;

class ConstructorDtoMapper
{
    /**
     * @param RouteConstructor $constructor
     * @return RouteConstructorDto
     */
    public static function fromRouteConstructorModel(RouteConstructor $constructor): RouteConstructorDto
    {
        return new RouteConstructorDto(
            points: PointDtoMapper::fromPointCollection($constructor->routePoints),
        );
    }
}
