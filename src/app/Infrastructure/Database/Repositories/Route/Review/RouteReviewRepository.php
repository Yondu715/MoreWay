<?php

namespace App\Infrastructure\Database\Repositories\Route\Review;

use App\Application\Contracts\Out\Repositories\Route\Review\IRouteReviewRepository;
use App\Application\DTO\Collection\CursorDto;
use App\Application\DTO\In\Route\Review\GetRouteReviewsDto;
use App\Application\DTO\Out\Review\ReviewDto;
use App\Application\Exceptions\Review\FailedToCreateReview;
use App\Infrastructure\Database\Models\RouteReview;
use App\Utils\Mappers\Out\Review\ReviewDtoMapper;
use Throwable;

class RouteReviewRepository implements IRouteReviewRepository
{
    /**
     * @param GetRouteReviewsDto $getReviewsDto
     * @return CursorDto
     */
    public function getAll(GetRouteReviewsDto $getReviewsDto): CursorDto
    {
        $paginator = RouteReview::query()
            ->where('route_id', $getReviewsDto->routeId)
            ->orderBy('created_at', 'desc')
            ->cursorPaginate(perPage: $getReviewsDto->limit ?? 2, cursor: $getReviewsDto->cursor);
        return ReviewDtoMapper::fromPaginator($paginator);
    }

    /**
     * @param array $attributes
     * @return ReviewDto
     * @throws FailedToCreateReview
     */
    public function create(array $attributes): ReviewDto
    {
        try {
            return ReviewDtoMapper::fromReviewModel(
                RouteReview::query()->create($attributes)
            );
        } catch (Throwable) {
            throw new FailedToCreateReview();
        }
    }
}
