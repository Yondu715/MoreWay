<?php

namespace App\Repositories\PlaceReview\Interfaces;

use App\DTO\In\PlaceReview\GetPlaceReviewsDto;
use App\Repositories\BaseRepository\Interfaces\IBaseRepository;
use Illuminate\Contracts\Pagination\CursorPaginator;

interface IPlaceReviewRepository extends IBaseRepository
{
    /**
     * @param GetPlaceReviewsDto $getReviewsDto
     * @return CursorPaginator
     */
    public function getReviews(GetPlaceReviewsDto $getReviewsDto): CursorPaginator;
}
