<?php

namespace App\Utils\Mappers\Out\Review;

use App\Application\DTO\Collection\CursorDto;
use App\Application\DTO\Out\Review\ReviewDto;
use App\Infrastructure\Database\Models\PlaceReview;
use App\Infrastructure\Database\Models\RouteReview;
use App\Utils\Mappers\Collection\CursorDtoMapper;
use App\Utils\Mappers\Out\Auth\UserDtoMapper;
use Illuminate\Pagination\CursorPaginator;

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

    /**
     * @param CursorPaginator $paginator
     * @return CursorDto
     */
    public static function fromPaginator(CursorPaginator $paginator): CursorDto
    {
        return CursorDtoMapper::fromPaginatorAndMapper($paginator, function (PlaceReview|RouteReview $review) {
            return self::fromReviewModel($review);
        });
    }
}
