<?php

namespace App\Services\Place\Review\Interfaces;

use App\DTO\In\Place\Review\CreateReviewDto;
use App\DTO\In\Place\Review\GetReviewsDto;
use App\DTO\Out\Place\ReviewDto;
use Illuminate\Contracts\Pagination\CursorPaginator;

interface IReviewService
{
    /**
     * @param CreateReviewDto $createReviewDto
     * @return ReviewDto
     */
    public function createReviews(CreateReviewDto $createReviewDto): ReviewDto;

    /**
     * @param GetReviewsDto $getReviewsDto
     * @return CursorPaginator
     */
    public function getReviews(GetReviewsDto $getReviewsDto): CursorPaginator;
}
