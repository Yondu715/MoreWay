<?php

namespace App\Services\Place\Review;

use App\DTO\In\Place\Review\CreateReviewDto;
use App\DTO\In\Place\Review\GetReviewsDto;
use App\DTO\Out\Place\ReviewDto;
use App\Exceptions\Review\FailedToCreateReview;
use App\Models\PlaceReview;
use App\Repositories\Place\Review\Interfaces\IReviewRepository;
use App\Services\Place\Review\Interfaces\IReviewService;
use Exception;
use Illuminate\Contracts\Pagination\CursorPaginator;

class ReviewService implements IReviewService
{
    public function __construct(
        private readonly IReviewRepository $reviewRepository
    ) {}

    /**
     * @param CreateReviewDto $createReviewDto
     * @return ReviewDto
     * @throws FailedToCreateReview
     */
    public function createReviews(CreateReviewDto $createReviewDto): ReviewDto
    {
        try {
            /** @var PlaceReview $review */
            $review = $this->reviewRepository->create([
                'author_id' => $createReviewDto->userId,
                'place_id' => $createReviewDto->placeId,
                'text' => $createReviewDto->text,
                'rating' => $createReviewDto->rating
            ]);
        }
        catch (Exception){
            throw new FailedToCreateReview();
        }

        return ReviewDto::fromReviewModel($review);
    }

    /**
     * @param GetReviewsDto $getReviewsDto
     * @return CursorPaginator
     */
    public function getReviews(GetReviewsDto $getReviewsDto): CursorPaginator
    {
        return $this->reviewRepository->getReviews($getReviewsDto);
    }
}
