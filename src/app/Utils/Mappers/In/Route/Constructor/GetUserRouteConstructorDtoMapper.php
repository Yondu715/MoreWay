<?php

namespace App\Utils\Mappers\In\Route\Constructor;

use App\Application\DTO\In\Route\Constructor\GetUserRouteConstructorDto;
use App\Infrastructure\Http\Requests\Route\Constructor\GetUserRouteConstructorRequest;

class GetUserRouteConstructorDtoMapper
{
    /**
     * @param GetUserRouteConstructorRequest $getUserRouteConstructorRequest
     * @return GetUserRouteConstructorDto
     */
    public static function fromRequest(GetUserRouteConstructorRequest $getUserRouteConstructorRequest): GetUserRouteConstructorDto
    {
        return new GetUserRouteConstructorDto(
            lat: $getUserRouteConstructorRequest->lat,
            lon: $getUserRouteConstructorRequest->lon,
            userId: (int)$getUserRouteConstructorRequest->route('userId'),
        );
    }
}
