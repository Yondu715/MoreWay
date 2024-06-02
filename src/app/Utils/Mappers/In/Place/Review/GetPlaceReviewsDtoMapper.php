<?php

namespace App\Utils\Mappers\In\Place\Review;

use App\Application\DTO\In\Place\Review\GetPlaceReviewsDto;
use App\Infrastructure\Http\Requests\Review\GetReviewsRequest;

class GetPlaceReviewsDtoMapper
{
    /**
     * @param GetReviewsRequest $getReviewsRequest
     * @return GetPlaceReviewsDto
     */
    public static function fromRequest(GetReviewsRequest $getReviewsRequest): GetPlaceReviewsDto
    {
        return new GetPlaceReviewsDto(
            placeId: $getReviewsRequest->route('placeId'),
            cursor: $getReviewsRequest->cursor,
            limit: $getReviewsRequest->limit
        );
    }
}
