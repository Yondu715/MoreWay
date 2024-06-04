<?php

namespace App\Utils\Mappers\Out\Route\Constructor;

use App\Application\DTO\Out\Route\Constructor\RouteConstructorDto;
use App\Infrastructure\Database\Models\RouteConstructor;
use App\Utils\Mappers\Out\Route\Constructor\Point\PointConstructorDtoMapper;
use Closure;

class ConstructorDtoMapper
{
    /**
     * @param RouteConstructor $constructor
     * @param ?Closure $distanceCalculator
     * @return RouteConstructorDto
     */
    public static function fromRouteConstructorModel(RouteConstructor $constructor, ?Closure $distanceCalculator = null): RouteConstructorDto
    {
        return new RouteConstructorDto(
            points: PointConstructorDtoMapper::fromPointCollection($constructor->routePoints, $distanceCalculator),
            id: $constructor->id
        );
    }
}
