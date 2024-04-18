<?php

namespace Src\App\Utils\Mappers\In\Route;

use App\Application\DTO\In\Route\CompleteRoutePointDto;
use App\Infrastructure\Http\Requests\Route\CompletedRoutePointRequest;

class CompleteRoutePointDtoMapper
{
    /**
     * @param CompletedRoutePointRequest $completedRoutePointRequest
     * @return CompleteRoutePointDto
     */
    public static function fromRequest(CompletedRoutePointRequest $completedRoutePointRequest): CompleteRoutePointDto
    {
        return new CompleteRoutePointDto(
            userId: $completedRoutePointRequest->userId,
            routeId: $completedRoutePointRequest->routeId,
            routePointId: $completedRoutePointRequest->routePointId
        );
    }
}