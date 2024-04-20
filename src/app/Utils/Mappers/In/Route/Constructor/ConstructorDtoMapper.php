<?php

namespace App\Utils\Mappers\In\Route\Constructor;

use App\Application\DTO\In\Route\Constructor\RouteConstructorDto;
use App\Infrastructure\Http\Requests\Route\Constructor\ChangeUserRouteConstructorRequest;
use App\Utils\Mappers\In\Route\Point\PointDtoMapper;

class ConstructorDtoMapper
{
    /**
     * @param ChangeUserRouteConstructorRequest $changeUserRouteConstructorRequest
     * @return RouteConstructorDto
     */
    public static function fromRequest(ChangeUserRouteConstructorRequest $changeUserRouteConstructorRequest): RouteConstructorDto
    {
        return new RouteConstructorDto(
            userId: (int)$changeUserRouteConstructorRequest->route('userId'),
            routePoints: PointDtoMapper::fromArray($changeUserRouteConstructorRequest->routePoints)
        );
    }
}
