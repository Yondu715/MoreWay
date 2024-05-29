<?php

namespace App\Utils\Mappers\Out\Route;

use App\Application\DTO\Collection\CursorDto;
use App\Application\DTO\Out\Route\ActiveRouteDto;
use App\Application\DTO\Out\Route\RouteDto;
use App\Infrastructure\Database\Models\Route;
use App\Infrastructure\Database\Models\UserActiveRoute;
use App\Utils\Mappers\Collection\CursorDtoMapper;
use App\Utils\Mappers\Out\User\UserDtoMapper;
use App\Utils\Mappers\Out\Route\Point\PointDtoMapper;
use Illuminate\Pagination\CursorPaginator;

class RouteDtoMapper
{
    public static function fromRouteModelAndActiveFavorite(Route $route, bool $isActive, bool $isFavorite): RouteDto
    {
        return new RouteDto(
            id: $route->id,
            name: $route->name,
            points: PointDtoMapper::fromPointCollection($route->routePoints),
            creator: UserDtoMapper::fromUserModel($route->creator),
            rating: $route->rating(),
            isActive: $isActive,
            isFavorite: $isFavorite
        );
    }

    /**
     * @param Route $route
     * @return RouteDto
     */
    public static function fromRouteModel(Route $route): RouteDto
    {
        return new RouteDto(
            id: $route->id,
            name: $route->name,
            points: PointDtoMapper::fromPointCollection($route->routePoints),
            creator: UserDtoMapper::fromUserModel($route->creator),
            rating: $route->rating()
        );
    }

    /**
     * @param Route $route
     * @param int $userId
     * @return RouteDto
     */
    public static function fromRouteModelAndUserId(Route $route, int $userId): RouteDto
    {
        return new RouteDto(
            id: $route->id,
            name: $route->name,
            points: PointDtoMapper::fromPointCollection($route->routePoints, $userId),
            creator: UserDtoMapper::fromUserModel($route->creator),
            rating: $route->rating()
        );
    }

    /**
     * @param UserActiveRoute $userActiveRoute
     * @return ActiveRouteDto
     */
    public static function fromActiveRouteModel(UserActiveRoute $userActiveRoute): ActiveRouteDto
    {
        return new ActiveRouteDto(
            isGroup: $userActiveRoute->is_group,
            route: RouteDtoMapper::fromRouteModelAndUserId($userActiveRoute->route, $userActiveRoute->user_id),
        );
    }

    /**
     * @param CursorPaginator $paginator
     * @return CursorDto
     */
    public static function fromPaginator(CursorPaginator $paginator): CursorDto
    {
        return CursorDtoMapper::fromPaginatorAndMapper($paginator, function ($route) {
            return RouteDtoMapper::fromRouteModel($route);
        });
    }
}
