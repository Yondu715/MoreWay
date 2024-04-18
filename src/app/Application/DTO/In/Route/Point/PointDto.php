<?php

namespace App\Application\DTO\In\Route\Point;

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
}
