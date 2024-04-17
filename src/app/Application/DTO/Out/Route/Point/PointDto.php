<?php

namespace App\Application\DTO\Out\Route\Point;

use App\Application\DTO\Out\Place\PlaceDto;

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
}
