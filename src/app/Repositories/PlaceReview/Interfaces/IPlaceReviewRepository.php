<?php

namespace App\Repositories\PlaceReview\Interfaces;

use App\DTO\In\PlaceReview\GetPlaceReviewsDto;
use Illuminate\Contracts\Pagination\CursorPaginator;

interface IPlaceReviewRepository
{
    /**
     * @param GetPlaceReviewsDto $getReviewsDto
     * @return CursorPaginator
     */
    public function getReviews(GetPlaceReviewsDto $getReviewsDto): CursorPaginator;
}
