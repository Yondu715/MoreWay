<?php

namespace App\Application\DTO\In\Route\Constructor;

class ChangeUserRouteConstructorDto
{
    public readonly float $lat;
    public readonly float $lon;
    public readonly int $userId;
    public readonly array $routePoints;

    public function __construct(
        float $lat,
        float $lon,
        int $userId,
        array $routePoints
    ) {
        $this->lat = $lat;
        $this->lon = $lon;
        $this->userId = $userId;
        $this->routePoints = $routePoints;
    }
}
