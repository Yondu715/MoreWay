<?php

namespace App\Application\DTO\In\Place;

class GetPlaceDto
{
    public readonly int $placeId;
    public readonly float $lat;
    public readonly float $lon;

    public function __construct(
        int $placeId,
        float $lat,
        float $lon
    ) {
        $this->placeId = $placeId;
        $this->lat = $lat;
        $this->lon = $lon;
    }
}
