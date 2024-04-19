<?php

namespace App\Application\DTO\In\Route;

class CreateRouteDto
{
    public readonly int $userId;
    public readonly string $name;
    public readonly array $routePoints;

    public function __construct(
        int $userId,
        string $name,
        array $routePoints
    ) {
        $this->userId = $userId;
        $this->name = $name;
        $this->routePoints = $routePoints;
    }

}
