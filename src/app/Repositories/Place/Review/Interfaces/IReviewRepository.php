<?php

namespace App\Repositories\Place\Review\Interfaces;

use App\DTO\In\Place\Review\CreateReviewDto;
use App\DTO\In\Place\Review\GetReviewsDto;
use App\Exceptions\Review\FailedToCreateReview;
use App\Models\PlaceReview;
use Illuminate\Contracts\Pagination\CursorPaginator;

interface IReviewRepository
{
    /**
     * @param CreateReviewDto $createReviewDto
     * @return PlaceReview
     * @throws FailedToCreateReview
     */
    public function createReviews(CreateReviewDto $createReviewDto): PlaceReview;

    /**
     * @param GetReviewsDto $getReviewsDto
     * @return CursorPaginator
     */
    public function getReviews(GetReviewsDto $getReviewsDto): CursorPaginator;
}
