<?php

namespace App\Utils\Mappers\Out\Route\Point;

use App\Application\DTO\Out\Route\Point\PointDto;
use App\Application\DTO\Out\Route\RouteDto;
use App\Infrastructure\Database\Models\RouteConstructorPoint;
use App\Infrastructure\Database\Models\RoutePoint;
use App\Utils\Mappers\Out\Place\PlaceDtoMapper;
use Illuminate\Support\Collection;

class PointDtoMapper
{
    /**
     * @param Collection<int, RoutePoint|RouteConstructorPoint> $routePoints
     * @return Collection<int, PointDto>
     */
    public static function fromPointCollection(Collection $routePoints, int $userId = null): Collection
    {
        return $routePoints->map(function (RoutePoint|RouteConstructorPoint $routePoint) use ($userId) {
            return new PointDto(
                id: $routePoint->id,
                index: $routePoint->index,
                place: PlaceDtoMapper::fromPlaceModel($routePoint->place),
                isCompleted: $routePoint
                    ->progresses
                    ->where('user_id', $userId)
                    ->first() ? $routePoint
                    ->progresses
                    ->where('user_id', $userId)
                    ->first()->is_completed : false
            );
        });
    }

    public static function fromPointModel(RoutePoint $routePoint): PointDto
    {
        return new PointDto(
            id: $routePoint->id,
            index: $routePoint->index,
            place: PlaceDtoMapper::fromPlaceModel($routePoint->place),
        );
    }
}
