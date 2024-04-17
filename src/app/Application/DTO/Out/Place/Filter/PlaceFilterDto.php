<?php

namespace App\Application\DTO\Out\Place\Filter;

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
}

