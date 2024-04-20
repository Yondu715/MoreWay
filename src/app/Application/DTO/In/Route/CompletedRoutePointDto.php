<?php

namespace App\Application\DTO\In\Route;

class CompletedRoutePointDto
{
    public readonly int $userId;
    public readonly int $routePointId;

    public function __construct(
        int $userId,
        int $routePointId
    ) {
        $this->userId = $userId;
        $this->routePointId = $routePointId;
    }
}
