<?php

namespace App\Repositories\PlaceReview;

use App\DTO\In\PlaceReview\GetPlaceReviewsDto;
use App\Models\PlaceReview;
use App\Repositories\BaseRepository\BaseRepository;
use App\Repositories\PlaceReview\Interfaces\IPlaceReviewRepository;
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
}
