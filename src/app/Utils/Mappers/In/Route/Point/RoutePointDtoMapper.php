<?php

namespace App\Utils\Mappers\In\Route\Point;

class RoutePointDtoMapper
{
    /**
     * @param array $routePoints
     * @return array
     */
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