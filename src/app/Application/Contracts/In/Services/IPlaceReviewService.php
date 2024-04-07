<?php

namespace App\Application\Contracts\In\Services;

use App\Application\DTO\Collection\CursorDto;
use App\Application\DTO\In\Place\Review\CreatePlaceReviewDto;
use App\Application\DTO\In\Place\Review\GetPlaceReviewsDto;
use App\Application\DTO\Out\Place\Review\PlaceReviewDto;

interface IPlaceReviewService
{
    /**
     * @param CreatePlaceReviewDto $createReviewDto
     * @return PlaceReviewDto
     */
    public function createReviews(CreatePlaceReviewDto $createReviewDto): PlaceReviewDto;

    /**
     * @param GetPlaceReviewsDto $getReviewsDto
     * @return CursorDto
     */
    public function getReviews(GetPlaceReviewsDto $getReviewsDto): CursorDto;
}
