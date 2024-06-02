<?php

namespace App\Application\Contracts\Out\Repositories\Place\Review;

use App\Application\DTO\Collection\CursorDto;
use App\Application\DTO\In\Place\Review\GetPlaceReviewsDto;
use App\Application\DTO\Out\Review\ReviewDto;
use App\Application\Exceptions\Review\FailedToCreateReview;

interface IPlaceReviewRepository
{
    /**
     * @param GetPlaceReviewsDto $getReviewsDto
     * @return CursorDto
     */
    public function findByPlaceId(GetPlaceReviewsDto $getReviewsDto): CursorDto;

    /**
     * @param array $attributes
     * @return ReviewDto
     * @throws FailedToCreateReview
     */
    public function create(array $attributes): ReviewDto;
}
