<?php

namespace App\Application\DTO\Out\Place;

use App\Application\DTO\Out\Place\PlaceDto;

class ExtendedPlaceDto
{
    public readonly PlaceDto $place;
    public readonly bool $isInConstructor;

    public function __construct(
        PlaceDto $place,
        bool $isInConstructor
    ) {
        $this->place = $place;
        $this->isInConstructor = $isInConstructor;
    }
}
