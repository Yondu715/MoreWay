<?php

namespace App\Utils\Mappers\In\Route;

use App\Application\DTO\In\Route\CompletedRoutePointDto;
use App\Infrastructure\Http\Requests\Route\CompletedRoutePointRequest;

class CompletedRoutePointDtoMapper
{
    /**
     * @param CompletedRoutePointRequest$completedRoutePointRequest
     * @return CompletedRoutePointDto
     */
    public static function fromRequest(CompletedRoutePointRequest $completedRoutePointRequest): CompletedRoutePointDto
    {
        return new CompletedRoutePointDto(
            userId: $completedRoutePointRequest->userId,
            routeId: $completedRoutePointRequest->routeId,
            routePointId: $completedRoutePointRequest->routePointId
        );
    }
}
