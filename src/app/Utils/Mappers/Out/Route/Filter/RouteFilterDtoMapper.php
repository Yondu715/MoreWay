<?php

namespace App\Utils\Mappers\Out\Route\Filter;

use App\Application\DTO\Out\Route\Filter\RouteFilterDto;

class RouteFilterDtoMapper
{
    /**
     * @param array<int, mixed> $filters
     * @return RouteFilterDto
     */
    public static function fromFilters(array $filters): RouteFilterDto
    {
        return new RouteFilterDto(
            minPassing: $filters['minPassing'],
            maxPassing: $filters['maxPassing'],
            minPoint: $filters['minPoint'],
            maxPoint: $filters['maxPoint'],
        );
    }
}
