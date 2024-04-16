<?php

namespace App\Infrastructure\Database\Models\Infrastructure\Database\Models\Infrastructure\Database\Repositories\Place\Review;

use App\Infrastructure\Database\Models\Infrastructure\Database\Models\Application\Contracts\Out\Repositories\Place\Review\IPlaceReviewRepository;
use App\Infrastructure\Database\Models\Infrastructure\Database\Models\Application\DTO\In\Place\Review\GetPlaceReviewsDto;
use App\Infrastructure\Database\Models\Infrastructure\Database\Models\Application\Exceptions\Review\FailedToCreateReview;
use App\Infrastructure\Database\Models\Infrastructure\Database\Models\Infrastructure\Database\Models\PlaceReview;
use App\Infrastructure\Database\Models\Infrastructure\Database\Models\Infrastructure\Database\Repositories\BaseRepository\BaseRepository;
use Illuminate\Contracts\Pagination\CursorPaginator;
use Throwable;

class PlaceReviewRepository extends BaseRepository implements IPlaceReviewRepository
{

    public function __construct(PlaceReview $review)
    {
        parent::__construct($review);
    }

    /**
     * @param GetPlaceReviewsDto $getReviewsDto
     * @return CursorPaginator
     */
    public function getReviews(GetPlaceReviewsDto $getReviewsDto): CursorPaginator
    {
        return $this->model->query()
            ->where('place_id', $getReviewsDto->placeId)
            ->orderBy('created_at', 'desc')
            ->cursorPaginate(perPage: $getReviewsDto->limit, cursor: $getReviewsDto->cursor);
    }


    /**
     * @param array $attributes
     * @return PlaceReview
     * @throws FailedToCreateReview
     */
    public function create(array $attributes): PlaceReview
    {
        try {
            /** @var PlaceReview */
            return parent::create($attributes);
        } catch (Throwable) {
            throw new FailedToCreateReview();
        }
    }
}
