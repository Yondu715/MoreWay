<?php

namespace App\Infrastructure\Database\Models\Infrastructure\Database\Models\Application\Contracts\In\Services\Place\Review;

use App\Infrastructure\Database\Models\Infrastructure\Database\Models\Application\DTO\Collection\CursorDto;
use App\Infrastructure\Database\Models\Infrastructure\Database\Models\Application\DTO\In\Place\Review\CreatePlaceReviewDto;
use App\Infrastructure\Database\Models\Infrastructure\Database\Models\Application\DTO\In\Place\Review\GetPlaceReviewsDto;
use App\Infrastructure\Database\Models\Infrastructure\Database\Models\Application\DTO\Out\Review\ReviewDto;

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
