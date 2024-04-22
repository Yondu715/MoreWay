<?php

namespace App\Application\DTO\In\Route;

class ChangeUserRouteDto
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

