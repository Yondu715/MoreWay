<?php

namespace App\Utils\Mappers\In\Route;

use App\Application\DTO\In\Route\CreateRouteDto;
use App\Infrastructure\Http\Requests\Route\CreateRouteRequest;
use App\Utils\Mappers\In\Route\Point\RoutePointDtoMapper;

class CreateRouteDtoMapper
{
    /**
     * @param CreateRouteRequest $createRouteRequest
     * @return CreateRouteDto
     */
    public static function fromRequest(CreateRouteRequest $createRouteRequest): CreateRouteDto
    {
        return new CreateRouteDto(
            userId: $createRouteRequest->userId,
            name: $createRouteRequest->name,
            routePoints: RoutePointDtoMapper::fromArray($createRouteRequest->routePoints)
        );
    }
}