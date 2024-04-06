<?php

namespace App\Application\Services\Place;

use App\Application\Contracts\In\Services\IPlaceReviewService;
use App\Application\Contracts\Out\Repositories\IPlaceReviewRepository;
use App\Application\DTO\In\PlaceReview\CreatePlaceReviewDto;
use App\Application\DTO\In\PlaceReview\GetPlaceReviewsDto;
use App\Application\DTO\Out\Place\PlaceReviewDto;
use App\Application\Exceptions\Place\FailedToCreatePlaceReview;
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
            $review = $this->reviewRepository->create([
                'author_id' => $createReviewDto->userId,
                'place_id' => $createReviewDto->placeId,
                'text' => $createReviewDto->text,
                'rating' => $createReviewDto->rating
            ]);
            return PlaceReviewDto::fromReviewModel($review);
        } catch (Exception $e) {
            throw new FailedToCreatePlaceReview();
        }
    }

    /**
     * @param GetPlaceReviewsDto $getReviewsDto
     * @return CursorPaginator
     */
    public function getReviews(GetPlaceReviewsDto $getReviewsDto): CursorPaginator
    {
        return $this->reviewRepository->getReviews($getReviewsDto);
    }
}
