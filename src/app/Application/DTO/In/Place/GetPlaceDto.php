<?php

namespace App\Application\DTO\In\Place;

class GetPlaceDto
{
    public readonly int $id;
    public readonly float $lat;
    public readonly float $lon;

    public function __construct(
        int $id,
        float $lat,
        float $lon
    ) {
        $this->id = $id;
        $this->lat = $lat;
        $this->lon = $lon;
    }
}
