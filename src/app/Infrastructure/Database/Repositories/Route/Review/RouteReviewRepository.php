<?php

namespace App\Infrastructure\Database\Models\Infrastructure\Database\Models\Infrastructure\Database\Repositories\Route\Review;

use App\Infrastructure\Database\Models\Infrastructure\Database\Models\Application\Contracts\Out\Repositories\Route\Review\IRouteReviewRepository;
use App\Infrastructure\Database\Models\Infrastructure\Database\Models\Application\DTO\In\Route\Review\GetRouteReviewsDto;
use App\Infrastructure\Database\Models\Infrastructure\Database\Models\Application\Exceptions\Review\FailedToCreateReview;
use App\Infrastructure\Database\Models\Infrastructure\Database\Models\Infrastructure\Database\Models\RouteReview;
use Illuminate\Contracts\Pagination\CursorPaginator;
use Throwable;

class RouteReviewRepository implements IRouteReviewRepository
{
    /**
     * @param GetRouteReviewsDto $getReviewsDto
     * @return CursorPaginator
     */
    public function getReviews(GetRouteReviewsDto $getReviewsDto): CursorPaginator
    {
        return RouteReview::query()
            ->where('route_id', $getReviewsDto->routeId)
            ->orderBy('created_at', 'desc')
            ->cursorPaginate(perPage: $getReviewsDto->limit, cursor: $getReviewsDto->cursor);
    }

    /**
     * @param array $attributes
     * @return RouteReview
     * @throws FailedToCreateReview
     */
    public function create(array $attributes): RouteReview
    {
        try {
            /** @var RouteReview */
            return RouteReview::query()->create($attributes);
        } catch (Throwable) {
            throw new FailedToCreateReview();
        }
    }
}
