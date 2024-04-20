<?php

namespace App\Application\DTO\In\Route;

class CompletedRoutePointDto
{
    public readonly int $userId;
    public readonly int $routeId;
    public readonly int $routePointId;

    public function __construct(
        int $userId,
        int $routeId,
        int $routePointId
    ) {
        $this->userId = $userId;
        $this->routeId = $routeId;
        $this->routePointId = $routePointId;
    }
}
