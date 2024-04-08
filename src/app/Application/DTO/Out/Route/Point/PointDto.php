<?php

namespace App\Application\DTO\Out\Route\Point;

use App\Application\DTO\Out\Place\PlaceDto;
use App\Infrastructure\Database\Models\RoutePoint;
use Illuminate\Support\Collection;

class PointDto
{
    public readonly int $id;
    public readonly int $index;
    public readonly PlaceDto $place;

    public function __construct(
        int $id,
        int $index,
        PlaceDto $place,
    ) {
        $this->id = $id;
        $this->index = $index;
        $this->place = $place;
    }

    /**
     * @param Collection<int, RoutePoint> $routePoints
     * @return Collection<int, RoutePoint>
     */
    public static function fromPointCollection(Collection $routePoints): Collection
    {
        return $routePoints->map(function ($routePoint) {
            return new self(
                id: $routePoint->id,
                index: $routePoint->index,
                place: PlaceDto::fromPlaceModel($routePoint->place),
            );
        });
    }
}
