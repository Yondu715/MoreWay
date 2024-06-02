<?php

namespace App\Infrastructure\Database\Repositories\Route\Review;

use App\Application\Contracts\Out\Repositories\Route\Review\IRouteReviewRepository;
use App\Application\DTO\Collection\CursorDto;
use App\Application\DTO\In\Route\Review\GetRouteReviewsDto;
use App\Application\DTO\Out\Review\ReviewDto;
use App\Application\Exceptions\Review\FailedToCreateReview;
use App\Infrastructure\Database\Models\RouteReview;
use App\Utils\Mappers\Out\Review\ReviewDtoMapper;
use Illuminate\Database\Eloquent\Model;
use Throwable;

class RouteReviewRepository implements IRouteReviewRepository
{
    private readonly Model $model;

    public function __construct(RouteReview $routeReview)
    {
        $this->model = $routeReview;
    }

    /**
     * @param GetRouteReviewsDto $getReviewsDto
     * @return CursorDto
     */
    public function findByRouteId(GetRouteReviewsDto $getReviewsDto): CursorDto
    {
        $paginator = $this->model->query()
            ->where('route_id', $getReviewsDto->routeId)
            ->orderBy('created_at', 'desc')
            ->cursorPaginate(perPage: $getReviewsDto->limit, cursor: $getReviewsDto->cursor);
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
            /** @var RouteReview $review */
            $review = $this->model->query()->create($attributes);
            return ReviewDtoMapper::fromReviewModel($review);
        } catch (Throwable) {
            throw new FailedToCreateReview();
        }
    }
}
