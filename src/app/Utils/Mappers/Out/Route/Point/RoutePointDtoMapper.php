<?php

namespace App\Utils\Mappers\Out\Route\Point;

use App\Application\DTO\Out\Route\Point\PointDto;
use App\Infrastructure\Database\Models\RoutePoint;
use App\Utils\Mappers\Out\Place\PlaceDtoMapper;
use Illuminate\Support\Collection;

class RoutePointDtoMapper
{
    /**
     * @param Collection<int, RoutePoint> $routePoints
     * @return Collection<int, PointDto>
     */
    public static function fromPointCollection(Collection $routePoints): Collection
    {
        return $routePoints->map(function (RoutePoint $routePoint) {
            return new PointDto(
                id: $routePoint->id,
                index: $routePoint->index,
                place: PlaceDtoMapper::fromPlaceModel($routePoint->place),
            );
        });
    }
}