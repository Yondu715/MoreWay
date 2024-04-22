<?php

namespace App\Utils\Mappers\In\Route;

use App\Application\DTO\In\Route\ChangeActiveUserRouteDto;
use App\Infrastructure\Http\Requests\Route\ChangeActiveUserRouteRequest;

class ChangeActiveUserRouteDtoMapper
{
    /**
     * @param ChangeActiveUserRouteRequest $changeActiveUserRouteRequest
     * @return ChangeActiveUserRouteDto
     */
    public static function fromRequest(ChangeActiveUserRouteRequest $changeActiveUserRouteRequest): ChangeActiveUserRouteDto
    {
        return new ChangeActiveUserRouteDto(
            userId: $changeActiveUserRouteRequest->route('userId'),
            routeId: $changeActiveUserRouteRequest->routeId
        );
    }
}
