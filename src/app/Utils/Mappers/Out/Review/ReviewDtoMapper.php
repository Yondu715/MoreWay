<?php

namespace App\Utils\Mappers\Out\Review;

use App\Application\DTO\Out\Review\ReviewDto;
use App\Infrastructure\Database\Models\PlaceReview;
use App\Infrastructure\Database\Models\RouteReview;
use App\Utils\Mappers\Out\Auth\UserDtoMapper;

class ReviewDtoMapper
{
    /**
     * @param PlaceReview|RouteReview $review
     * @return ReviewDto
     */
    public static function fromReviewModel(PlaceReview|RouteReview $review): ReviewDto
    {
        return new ReviewDto(
            id: $review->id,
            text: $review->text,
            rating: $review->rating,
            createdAt: $review->created_at->format('Y-m-d H:i:s'),
            author: UserDtoMapper::fromUserModel($review->author),
        );
    }
}