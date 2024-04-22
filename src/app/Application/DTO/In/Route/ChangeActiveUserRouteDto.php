<?php

namespace App\Application\DTO\In\Route;

class ChangeActiveUserRouteDto
{
    public readonly int $userId;
    public readonly int $routeId;

    public function __construct(
        int $userId,
        int $routeId
    ) {
        $this->userId = $userId;
        $this->routeId = $routeId;
    }
}

