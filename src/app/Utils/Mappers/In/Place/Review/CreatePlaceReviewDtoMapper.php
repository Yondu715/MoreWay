<?php

namespace App\Utils\Mappers\In\Place\Review;

use App\Application\DTO\In\Place\Review\CreatePlaceReviewDto;
use App\Infrastructure\Http\Requests\Review\CreateReviewRequest;

class CreatePlaceReviewDtoMapper
{
    /**
     * @param CreateReviewRequest $createReviewRequest
     * @return CreatePlaceReviewDto
     */
    public static function fromRequest(CreateReviewRequest $createReviewRequest): CreatePlaceReviewDto
    {
        return new CreatePlaceReviewDto(
            placeId: $createReviewRequest->route('placeId'),
            userId: $createReviewRequest->userId,
            rating: $createReviewRequest->rating,
            text: $createReviewRequest->text
        );
    }
}