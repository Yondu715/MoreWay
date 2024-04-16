<?php

namespace App\Application\Contracts\Out\Repositories\Route\Review;

use App\Application\DTO\In\Route\Review\GetRouteReviewsDto;
use App\Application\Exceptions\Review\FailedToCreateReview;
use App\Infrastructure\Database\Models\RouteReview;
use Illuminate\Contracts\Pagination\CursorPaginator;

interface IRouteReviewRepository
{
    /**
     * @param GetRouteReviewsDto $getReviewsDto
     * @return CursorPaginator
     */
    public function getReviews(GetRouteReviewsDto $getReviewsDto): CursorPaginator;

    /**
     * @param array $attributes
     * @return RouteReview
     * @throws FailedToCreateReview
     */
    public function create(array $attributes): RouteReview;
}
