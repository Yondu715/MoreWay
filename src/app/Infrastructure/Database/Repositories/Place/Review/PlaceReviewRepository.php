<?php

namespace App\Infrastructure\Database\Repositories\Place\Review;

use Throwable;
use Illuminate\Database\Eloquent\Model;
use App\Application\DTO\Collection\CursorDto;
use App\Application\DTO\Out\Review\ReviewDto;
use App\Utils\Mappers\Out\Review\ReviewDtoMapper;
use App\Infrastructure\Database\Models\PlaceReview;
use App\Application\DTO\In\Place\Review\GetPlaceReviewsDto;
use App\Application\Exceptions\Review\FailedToCreateReview;
use App\Application\Contracts\Out\Repositories\Place\Review\IPlaceReviewRepository;

class PlaceReviewRepository implements IPlaceReviewRepository
{

    private readonly Model $model;

    public function __construct(PlaceReview $review)
    {
        $this->model = $review;
    }

    /**
     * @param GetPlaceReviewsDto $getReviewsDto
     * @return CursorDto
     */
    public function findByPlaceId(GetPlaceReviewsDto $getReviewsDto): CursorDto
    {
        $reviews = $this->model->query()
            ->where('place_id', $getReviewsDto->placeId)
            ->with('author')
            ->orderBy('created_at', 'desc')
            ->cursorPaginate(perPage: $getReviewsDto->limit, cursor: $getReviewsDto->cursor);
        return ReviewDtoMapper::fromPaginator($reviews);
    }


    /**
     * @param array $attributes
     * @return ReviewDto
     * @throws FailedToCreateReview
     */
    public function create(array $attributes): ReviewDto
    {
        try {
            /** @var PlaceReview $review */
            $review = $this->model->query()->create($attributes);
            return ReviewDtoMapper::fromReviewModel($review);
        } catch (Throwable) {
            throw new FailedToCreateReview();
        }
    }
}
