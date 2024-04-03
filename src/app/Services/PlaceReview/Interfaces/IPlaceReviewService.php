<?php

namespace App\Services\PlaceReview\Interfaces;

use App\DTO\In\PlaceReview\CreatePlaceReviewDto;
use App\DTO\In\PlaceReview\GetPlaceReviewsDto;
use App\DTO\Out\PlaceReview\PlaceReviewDto;
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
