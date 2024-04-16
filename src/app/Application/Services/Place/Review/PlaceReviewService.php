<?php

namespace App\Infrastructure\Database\Models\Infrastructure\Database\Models\Application\Services\Place\Review;

use App\Infrastructure\Database\Models\Infrastructure\Database\Models\Application\Contracts\In\Services\Place\Review\IPlaceReviewService;
use App\Infrastructure\Database\Models\Infrastructure\Database\Models\Application\Contracts\Out\Repositories\Place\Review\IPlaceReviewRepository;
use App\Infrastructure\Database\Models\Infrastructure\Database\Models\Application\DTO\Collection\CursorDto;
use App\Infrastructure\Database\Models\Infrastructure\Database\Models\Application\DTO\In\Place\Review\CreatePlaceReviewDto;
use App\Infrastructure\Database\Models\Infrastructure\Database\Models\Application\DTO\In\Place\Review\GetPlaceReviewsDto;
use App\Infrastructure\Database\Models\Infrastructure\Database\Models\Application\DTO\Out\Review\ReviewCursorDto;
use App\Infrastructure\Database\Models\Infrastructure\Database\Models\Application\DTO\Out\Review\ReviewDto;
use App\Infrastructure\Database\Models\Infrastructure\Database\Models\Application\Exceptions\Review\FailedToCreateReview;
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
            $review = $this->reviewRepository->create([
                'author_id' => $createReviewDto->userId,
                'place_id' => $createReviewDto->placeId,
                'text' => $createReviewDto->text,
                'rating' => $createReviewDto->rating
            ]);
            return ReviewDto::fromReviewModel($review);
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
        return ReviewCursorDto::fromPaginator($this->reviewRepository->getReviews($getReviewsDto));
    }
}
