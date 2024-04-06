<?php

namespace App\Infrastructure\Database\Repositories\Place;

use App\Application\Contracts\Out\Repositories\IPlaceReviewRepository;
use App\Application\DTO\In\PlaceReview\GetPlaceReviewsDto;
use App\Application\Exceptions\Place\FailedToCreatePlaceReview;
use App\Infrastructure\Database\Models\PlaceReview;
use App\Infrastructure\Database\Repositories\BaseRepository\BaseRepository;
use Illuminate\Contracts\Pagination\CursorPaginator;

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

    public function create(array $attributes): PlaceReview
    {
        try {
            /** @var PlaceReview */
            return parent::create($attributes);
        } catch (\Throwable $th) {
            throw new FailedToCreatePlaceReview();
        }
    }
}
