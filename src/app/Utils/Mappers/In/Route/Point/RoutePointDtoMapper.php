<?php

namespace App\Utils\Mappers\In\Route\Point;

use App\Application\DTO\In\Route\Point\PointDto;

class RoutePointDtoMapper
{
    /**
     * @param array $routePoints
     * @return array<int, PointDto>
     */
    public static function fromArray(array $routePoints): array
    {
        return array_map(function ($routePoint) {
            return new PointDto(
                index: $routePoint['index'],
                placeId: $routePoint['placeId']
            );
        }, $routePoints);
    }
}