<?php

namespace App\Infrastructure\Database\Models\Infrastructure\Database\Models\Application\DTO\In\Route\Point;

class PointDto
{
    public readonly int $index;
    public readonly int $placeId;

    public function __construct(
        int $index,
        int $placeId
    ) {
        $this->index = $index;
        $this->placeId = $placeId;
    }

    public static function fromArray(array $routePoints): array
    {
        return array_map(function ($routePoint) {
            return new self(
                index: $routePoint['index'],
                placeId: $routePoint['placeId']
            );
        }, $routePoints);
    }
}
