<?php

namespace App\Utils\Mappers\Out\Route\Point;

use Illuminate\Support\Collection;
use App\Utils\Mappers\Out\Place\PlaceDtoMapper;
use App\Application\DTO\Out\Route\Point\PointDto;
use App\Infrastructure\Database\Models\RoutePoint;
use App\Infrastructure\Database\Models\RouteConstructorPoint;

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
                    ->first()?->is_completed
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
