<?php

namespace App\Application\Contracts\In\Services\Route\Review;

use App\Application\DTO\Collection\CursorDto;
use App\Application\DTO\In\Route\Review\CreateRouteReviewDto;
use App\Application\DTO\In\Route\Review\GetRouteReviewsDto;
use App\Application\DTO\Out\Review\ReviewDto;

interface IRouteReviewService
{
    /**
     * @param CreateRouteReviewDto $createReviewDto
     * @return ReviewDto
     */
    public function createReviews(CreateRouteReviewDto $createReviewDto): ReviewDto;

    /**
     * @param GetRouteReviewsDto $getReviewsDto
     * @return CursorDto
     */
    public function getReviews(GetRouteReviewsDto $getReviewsDto): CursorDto;
}
