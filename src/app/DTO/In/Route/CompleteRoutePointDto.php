<?php

namespace App\DTO\In\Route;

use App\Http\Requests\Route\CompletedRoutePointRequest;

class CompleteRoutePointDto
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

    public static function fromRequest(CompletedRoutePointRequest $completedRoutePointRequest): self
    {
        return new self(
            userId: $completedRoutePointRequest->userId,
            routeId: $completedRoutePointRequest->routeId,
            routePointId: $completedRoutePointRequest->routePointId
        );
    }
}