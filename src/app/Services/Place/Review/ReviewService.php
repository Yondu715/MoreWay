<?php

namespace App\Services\Place\Review;

use App\DTO\In\Place\Review\CreateReviewDto;
use App\DTO\In\Place\Review\GetReviewsDto;
use App\Exceptions\Review\FailedToCreateReview;
use App\Models\PlaceReview;
use App\Repositories\Place\Review\Interfaces\IReviewRepository;
use App\Services\Place\Review\Interfaces\IReviewService;
use Illuminate\Contracts\Pagination\CursorPaginator;

class ReviewService implements IReviewService
{
    public function __construct(
        private readonly IReviewRepository $reviewRepository
    ) {}

    /**
     * @param CreateReviewDto $createReviewDto
     * @return PlaceReview
     * @throws FailedToCreateReview
     */
    public function createReviews(CreateReviewDto $createReviewDto): PlaceReview
    {
        return $this->reviewRepository->createReviews($createReviewDto);
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
