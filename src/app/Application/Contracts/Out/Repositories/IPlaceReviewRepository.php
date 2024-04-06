<?php

namespace App\Application\Contracts\Out\Repositories;

use App\Application\DTO\In\PlaceReview\GetPlaceReviewsDto;
use Illuminate\Contracts\Pagination\CursorPaginator;

interface IPlaceReviewRepository extends IBaseRepository
{
    /**
     * @param GetPlaceReviewsDto $getReviewsDto
     * @return CursorPaginator
     */
    public function getReviews(GetPlaceReviewsDto $getReviewsDto): CursorPaginator;
}
