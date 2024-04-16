<?php

namespace App\Infrastructure\Database\Models\Infrastructure\Database\Models\Application\Contracts\Out\Repositories\Route\Review;

use App\Infrastructure\Database\Models\Infrastructure\Database\Models\Application\DTO\In\Route\Review\GetRouteReviewsDto;
use App\Infrastructure\Database\Models\Infrastructure\Database\Models\Application\Exceptions\Review\FailedToCreateReview;
use App\Infrastructure\Database\Models\Infrastructure\Database\Models\Infrastructure\Database\Models\RouteReview;
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
