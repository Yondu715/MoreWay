<?php

namespace App\Utils\Mappers\In\Route;

use App\Application\DTO\In\Route\ChangeUserRouteDto;
use App\Infrastructure\Http\Requests\Route\ChangeUserRouteRequest;

class ChangeUserRouteDtoMapper
{
    /**
     * @param ChangeUserRouteRequest $changeActiveUserRouteRequest
     * @return ChangeUserRouteDto
     */
    public static function fromRequest(ChangeUserRouteRequest $changeActiveUserRouteRequest): ChangeUserRouteDto
    {
        return new ChangeUserRouteDto(
            userId: $changeActiveUserRouteRequest->route('userId'),
            routeId: $changeActiveUserRouteRequest->routeId
        );
    }
}
