<?php

namespace App\Application\Contracts\In\Services\Place\Review;

use App\Application\DTO\Collection\CursorDto;
use App\Application\DTO\In\Place\Review\CreatePlaceReviewDto;
use App\Application\DTO\In\Place\Review\GetPlaceReviewsDto;
use App\Application\DTO\Out\Review\ReviewDto;

interface IPlaceReviewService
{
    /**
     * @param CreatePlaceReviewDto $createReviewDto
     * @return ReviewDto
     */
    public function createReviews(CreatePlaceReviewDto $createReviewDto): ReviewDto;

    /**
     * @param GetPlaceReviewsDto $getReviewsDto
     * @return CursorDto
     */
    public function getReviews(GetPlaceReviewsDto $getReviewsDto): CursorDto;
}
