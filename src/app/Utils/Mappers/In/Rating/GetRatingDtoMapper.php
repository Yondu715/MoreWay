<?php

namespace App\Utils\Mappers\In\Rating;

use App\Application\DTO\In\Rating\GetRatingDto;
use App\Infrastructure\Http\Requests\Rating\GetRatingRequest;

class GetRatingDtoMapper
{
    /**
     * @param GetRatingRequest $getRatingRequest
     * @return GetRatingDto
     */
    public static function fromRequest(GetRatingRequest $getRatingRequest): GetRatingDto
    {
        return new GetRatingDto(
            cursor: $getRatingRequest->cursor,
            limit: $getRatingRequest->limit
        );
    }
}
