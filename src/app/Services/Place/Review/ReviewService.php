<?php

namespace App\Services\Place\Review;

use App\DTO\In\Place\Review\CreateReviewDto;
use App\DTO\In\Place\Review\GetReviewsDto;
use App\Exceptions\Review\FailedToCreateReview;
use App\Models\PlaceReview;
use App\Services\Place\Review\Interfaces\IReviewService;
use Exception;
use Illuminate\Contracts\Pagination\CursorPaginator;

class ReviewService implements IReviewService
{
    /**
     * @param CreateReviewDto $createReviewDto
     * @return PlaceReview
     * @throws FailedToCreateReview
     */
    public function createReviews(CreateReviewDto $createReviewDto): PlaceReview
    {
        try {
            /** @var PlaceReview $placeReview */
            $placeReview = PlaceReview::query()->create([
                'author_id' => $createReviewDto->userId,
                'place_id' => $createReviewDto->placeId,
                'text' => $createReviewDto->text,
                'rating' => $createReviewDto->rating
            ]);
        }
        catch (Exception){
            throw new FailedToCreateReview();
        }

        return $placeReview;
    }

    /**
     * @param GetReviewsDto $getReviewsDto
     * @return CursorPaginator
     */
    public function getReviews(GetReviewsDto $getReviewsDto): CursorPaginator
    {
        return PlaceReview::query()
            ->where('place_id', $getReviewsDto->placeId)
            ->orderBy('created_at', 'desc')
            ->cursorPaginate(perPage: 1, cursor: $getReviewsDto->cursor);
    }
}
