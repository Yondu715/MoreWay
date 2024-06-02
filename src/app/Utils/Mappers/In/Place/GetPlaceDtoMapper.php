<?php

namespace App\Utils\Mappers\In\Place;

use App\Application\DTO\In\Place\GetPlaceDto;
use App\Infrastructure\Http\Requests\Place\GetPlaceRequest;

class GetPlaceDtoMapper
{
    /**
     * @param GetPlaceRequest $getPlaceRequest
     * @return GetPlaceDto
     */
    public static function fromRequest(GetPlaceRequest $getPlaceRequest): GetPlaceDto
    {
        return new GetPlaceDto(
            placeId: $getPlaceRequest->route('placeId'),
            lat: $getPlaceRequest->lat,
            lon: $getPlaceRequest->lon
        );
    }
}