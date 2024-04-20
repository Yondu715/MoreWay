<?php

namespace App\Utils\Mappers\Out\Route;

use App\Application\DTO\Out\Route\RouteDto;
use App\Infrastructure\Database\Models\Route;
use App\Utils\Mappers\Out\Auth\UserDtoMapper;
use App\Utils\Mappers\Out\Route\Point\RoutePointDtoMapper;

class RouteDtoMapper
{
    /**
     * @param Route $route
     * @return RouteDto
     */
    public static function fromRouteModel(Route $route): RouteDto
    {
        return new RouteDto(
            id: $route->id,
            name: $route->name,
            points: RoutePointDtoMapper::fromPointCollection($route->routePoints),
            creator: UserDtoMapper::fromUserModel($route->creator),
            rating: $route->rating()
        );
    }
}
