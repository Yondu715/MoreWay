<?php

namespace App\Application\DTO\In\Route;

class CompletedRoutePointDto
{
    public int $userId;
    public readonly int $routePointId;
    public readonly float $lat;
    public readonly float $lon;

    public function __construct(
        int $userId,
        int $routePointId,
        float $lat,
        float $lon
    ) {
        $this->userId = $userId;
        $this->routePointId = $routePointId;
        $this->lat = $lat;
        $this->lon = $lon;
    }
}
