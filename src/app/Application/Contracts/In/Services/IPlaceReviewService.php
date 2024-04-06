<?php

namespace App\Application\Contracts\In\Services;

use App\Application\DTO\In\PlaceReview\CreatePlaceReviewDto;
use App\Application\DTO\In\PlaceReview\GetPlaceReviewsDto;
use App\Application\DTO\Out\Place\PlaceReviewDto;
use Illuminate\Contracts\Pagination\CursorPaginator;

interface IPlaceReviewService
{
    /**
     * @param CreatePlaceReviewDto $createReviewDto
     * @return PlaceReviewDto
     */
    public function createReviews(CreatePlaceReviewDto $createReviewDto): PlaceReviewDto;

    /**
     * @param GetPlaceReviewsDto $getReviewsDto
     * @return CursorPaginator
     */
    public function getReviews(GetPlaceReviewsDto $getReviewsDto): CursorPaginator;
}
