<?php

namespace App\Application\DTO\In\Route\Constructor;

class RouteConstructorDto
{
    public readonly int $userId;
    public readonly array $routePoints;

    public function __construct(
        int $userId,
        array $routePoints
    ) {
        $this->userId = $userId;
        $this->routePoints = $routePoints;
    }
}
