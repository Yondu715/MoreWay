<?php

namespace App\Utils\Mappers\In\Route\Review;

use App\Application\DTO\In\Route\Review\GetRouteReviewsDto;
use App\Infrastructure\Http\Requests\Review\GetReviewsRequest;

class GetRouteReviewsDtoMapper
{
    /**
     * @param GetReviewsRequest $getReviewsRequest
     * @return GetRouteReviewsDto
     */
    public static function fromRequest(GetReviewsRequest $getReviewsRequest): GetRouteReviewsDto
    {
        return new GetRouteReviewsDto(
            routeId: (int)$getReviewsRequest->route('routeId'),
            cursor: $getReviewsRequest->cursor,
            limit: $getReviewsRequest->limit ?? 2
        );
    }
}