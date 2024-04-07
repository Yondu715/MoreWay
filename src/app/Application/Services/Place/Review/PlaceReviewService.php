<?php

namespace App\Application\Services\Place\Review;

use App\Application\Contracts\In\Services\IPlaceReviewService;
use App\Application\Contracts\Out\Repositories\IPlaceReviewRepository;
use App\Application\DTO\Collection\CursorDto;
use App\Application\DTO\In\Place\Review\CreatePlaceReviewDto;
use App\Application\DTO\In\Place\Review\GetPlaceReviewsDto;
use App\Application\DTO\Out\Place\Review\PlaceReviewCursorDto;
use App\Application\DTO\Out\Place\Review\PlaceReviewDto;
use App\Application\Exceptions\Place\Review\FailedToCreatePlaceReview;
use App\Infrastructure\Database\Models\PlaceReview;
use Exception;
use Illuminate\Contracts\Pagination\CursorPaginator;

class PlaceReviewService implements IPlaceReviewService
{
    public function __construct(
        private readonly IPlaceReviewRepository $reviewRepository
    ) {
    }

    /**
     * @param CreatePlaceReviewDto $createReviewDto
     * @return PlaceReviewDto
     * @throws FailedToCreatePlaceReview
     */
    public function createReviews(CreatePlaceReviewDto $createReviewDto): PlaceReviewDto
    {
        try {
            /** @var PlaceReview $review */
            $review = $this->reviewRepository->create([
                'author_id' => $createReviewDto->userId,
                'place_id' => $createReviewDto->placeId,
                'text' => $createReviewDto->text,
                'rating' => $createReviewDto->rating
            ]);
            return PlaceReviewDto::fromReviewModel($review);
        } catch (Exception) {
            throw new FailedToCreatePlaceReview();
        }
    }

    /**
     * @param GetPlaceReviewsDto $getReviewsDto
     * @return CursorDto
     */
    public function getReviews(GetPlaceReviewsDto $getReviewsDto): CursorDto
    {
        return PlaceReviewCursorDto::fromPaginator($this->reviewRepository->getReviews($getReviewsDto));
    }
}
