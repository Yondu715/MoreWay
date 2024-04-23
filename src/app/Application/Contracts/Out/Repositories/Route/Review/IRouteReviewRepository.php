<?php

namespace App\Application\Contracts\Out\Repositories\Route\Review;

use App\Application\DTO\Collection\CursorDto;
use App\Application\DTO\In\Route\Review\GetRouteReviewsDto;
use App\Application\DTO\Out\Review\ReviewDto;
use App\Application\Exceptions\Review\FailedToCreateReview;

interface IRouteReviewRepository
{
    /**
     * @param GetRouteReviewsDto $getReviewsDto
     * @return CursorDto
     */
    public function getAll(GetRouteReviewsDto $getReviewsDto): CursorDto;

    /**
     * @param array $attributes
     * @return ReviewDto
     * @throws FailedToCreateReview
     */
    public function create(array $attributes): ReviewDto;
}
