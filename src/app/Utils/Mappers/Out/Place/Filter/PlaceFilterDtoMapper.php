<?php

namespace App\Utils\Mappers\Out\Place\Filter;

use App\Application\DTO\Out\Place\Filter\PlaceFilterDto;
use App\Utils\Mappers\Out\Place\Locality\LocalityDtoMapper;
use App\Utils\Mappers\Out\Place\Type\PlaceTypeDtoMapper;

class PlaceFilterDtoMapper
{
    /**
     * @param array<int, mixed> $filters
     * @return PlaceFilterDto
     */
    public static function fromFilters(array $filters): PlaceFilterDto
    {
        return new PlaceFilterDto(
            localities: LocalityDtoMapper::fromLocalityCollection($filters['localities']),
            types: PlaceTypeDtoMapper::fromTypeCollection($filters['types']),
            minDistance: $filters['minDistance'],
            maxDistance: $filters['maxDistance']
        );
    }
}