<?php

namespace App\Application\Services\Place\Review;

use App\Application\Contracts\In\Services\Place\Review\IPlaceReviewService;
use App\Application\Contracts\Out\Repositories\Place\Review\IPlaceReviewRepository;
use App\Application\DTO\Collection\CursorDto;
use App\Application\DTO\In\Place\Review\CreatePlaceReviewDto;
use App\Application\DTO\In\Place\Review\GetPlaceReviewsDto;
use App\Application\DTO\Out\Review\ReviewDto;
use App\Application\Exceptions\Review\FailedToCreateReview;
use Throwable;

class PlaceReviewService implements IPlaceReviewService
{
    public function __construct(
        private readonly IPlaceReviewRepository $reviewRepository
    ) {}

    /**
     * @param CreatePlaceReviewDto $createReviewDto
     * @return ReviewDto
     * @throws FailedToCreateReview
     */
    public function createReviews(CreatePlaceReviewDto $createReviewDto): ReviewDto
    {
        try {
            return $this->reviewRepository->create([
                'author_id' => $createReviewDto->userId,
                'place_id' => $createReviewDto->placeId,
                'text' => $createReviewDto->text,
                'rating' => $createReviewDto->rating
            ]);
        } catch (Throwable) {
            throw new FailedToCreateReview();
        }
    }

    /**
     * @param GetPlaceReviewsDto $getReviewsDto
     * @return CursorDto
     */
    public function getReviews(GetPlaceReviewsDto $getReviewsDto): CursorDto
    {
        return $this->reviewRepository->getAll($getReviewsDto);
    }
}
