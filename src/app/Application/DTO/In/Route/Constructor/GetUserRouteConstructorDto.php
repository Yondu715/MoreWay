<?php

namespace App\Application\DTO\In\Route\Constructor;

class GetUserRouteConstructorDto
{
    public readonly float $lat;
    public readonly float $lon;
    public readonly int $userId;

    public function __construct(
        float $lat,
        float $lon,
        int $userId,
    ) {
        $this->lat = $lat;
        $this->lon = $lon;
        $this->userId = $userId;
    }
}
