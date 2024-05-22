<?php

namespace App\Utils\Mappers\In\Route\Constructor;

use App\Application\DTO\In\Route\Constructor\ChangeUserRouteConstructorDto;
use App\Infrastructure\Http\Requests\Route\Constructor\ChangeUserRouteConstructorRequest;
use App\Utils\Mappers\In\Route\Point\PointDtoMapper;

class ChangeUserRouteConstructorDtoMapper
{
    /**
     * @param ChangeUserRouteConstructorRequest $changeUserRouteConstructorRequest
     * @return ChangeUserRouteConstructorDto
     */
    public static function fromRequest(ChangeUserRouteConstructorRequest $changeUserRouteConstructorRequest): ChangeUserRouteConstructorDto
    {
        return new ChangeUserRouteConstructorDto(
            lat: $changeUserRouteConstructorRequest->lat,
            lon: $changeUserRouteConstructorRequest->lon,
            userId: (int)$changeUserRouteConstructorRequest->route('userId'),
            routePoints: PointDtoMapper::fromArray($changeUserRouteConstructorRequest->items)
        );
    }
}
