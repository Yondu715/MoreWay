<?php

namespace App\Utils\Mappers\Out\Route\Constructor\Point;

use App\Application\DTO\Out\Route\Point\PointDto;
use App\Infrastructure\Database\Models\RouteConstructorPoint;
use App\Infrastructure\Database\Models\RoutePoint;
use App\Utils\Mappers\Out\Place\PlaceDtoMapper;
use Closure;
use Illuminate\Support\Collection;

class PointConstructorDtoMapper
{
    /**
     * @param Collection<int, RoutePoint|RouteConstructorPoint> $routePoints
     * @return Collection<int, PointDto>
     */
    public static function fromPointCollection(Collection $routePoints, ?Closure $distanceCalculator = null): Collection
    {
        return $routePoints->map(function (RoutePoint|RouteConstructorPoint $routePoint) use ($distanceCalculator) {
            return new PointDto(
                id: $routePoint->id,
                index: $routePoint->index,
                place: PlaceDtoMapper::fromPlaceModel($routePoint->place, $distanceCalculator && $distanceCalculator($routePoint->place->lat, $routePoint->place->lon)),
            );
        });
    }
}
