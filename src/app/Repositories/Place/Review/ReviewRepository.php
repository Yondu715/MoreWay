<?php

namespace App\Repositories\Place\Review;

use App\DTO\In\Place\Review\CreateReviewDto;
use App\DTO\In\Place\Review\GetReviewsDto;
use App\Exceptions\Review\FailedToCreateReview;
use App\Models\PlaceReview;
use App\Repositories\BaseRepository\BaseRepository;
use App\Repositories\Place\Review\Interfaces\IReviewRepository;
use Exception;
use Illuminate\Contracts\Pagination\CursorPaginator;

class ReviewRepository extends BaseRepository implements IReviewRepository
{

    public function __construct(PlaceReview $review)
    {
        parent::__construct($review);
    }

    /**
     * @param GetReviewsDto $getReviewsDto
     * @return CursorPaginator
     */
    public function getReviews(GetReviewsDto $getReviewsDto): CursorPaginator
    {
        return $this->model->query()
            ->where('place_id', $getReviewsDto->placeId)
            ->orderBy('created_at', 'desc')
            ->cursorPaginate(perPage: $getReviewsDto->limit, cursor: $getReviewsDto->cursor);
    }
}
