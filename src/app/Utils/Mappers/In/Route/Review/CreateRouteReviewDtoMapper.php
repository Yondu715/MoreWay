<?php

namespace App\Utils\Mappers\In\Route\Review;

use App\Application\DTO\In\Route\Review\CreateRouteReviewDto;
use App\Infrastructure\Http\Requests\Review\CreateReviewRequest;

class CreateRouteReviewDtoMapper
{
    /**
     * @param CreateReviewRequest $createReviewRequest
     * @return CreateRouteReviewDto
     */
    public static function fromRequest(CreateReviewRequest $createReviewRequest): CreateRouteReviewDto
    {
        return new CreateRouteReviewDto(
            routeId: (int)$createReviewRequest->route('routeId'),
            userId: $createReviewRequest->userId,
            rating: $createReviewRequest->rating,
            text: $createReviewRequest->text
        );
    }
}