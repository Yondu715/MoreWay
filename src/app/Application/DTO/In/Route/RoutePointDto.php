<?php

namespace App\Application\DTO\In\Route;

class RoutePointDto
{
    public readonly int $index;
    public readonly int $routePointId;

    public function __construct(
        int $index,
        int $routePointId
    ) {
        $this->index = $index;
        $this->routePointId = $routePointId;
    }

    public static function fromArray(array $routePoints): array
    {
        return array_map(function ($routePoint) {
            return new self(
                index: $routePoint->index,
                routePointId: $routePoint->routePointId
            );
        }, $routePoints);
    }
}
