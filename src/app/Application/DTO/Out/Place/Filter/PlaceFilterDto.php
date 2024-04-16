<?php

namespace App\Application\DTO\Out\Place\Filter;

use App\Application\DTO\Out\Place\Locality\LocalityDto;
use App\Application\DTO\Out\Place\Type\PlaceTypeDto;
use Illuminate\Support\Collection;

class PlaceFilterDto
{
    public readonly Collection $localities;
    public readonly Collection $types;
    public readonly int $minDistance;
    public readonly int $maxDistance;

    public function __construct(
        Collection $localities,
        Collection $types,
        int $minDistance,
        int $maxDistance,
    ) {

        $this->localities = $localities;
        $this->types = $types;
        $this->minDistance = $minDistance;
        $this->maxDistance = $maxDistance;
    }

    /**
     * @param array $filters
     * @return self
     */
    public static function fromFilters(array $filters): self
    {
        return new self(
            localities: LocalityDto::fromLocalityCollection($filters['localities']),
            types: PlaceTypeDto::fromTypeCollection($filters['types']),
            minDistance: $filters['minDistance'],
            maxDistance: $filters['maxDistance']
        );
    }
}

