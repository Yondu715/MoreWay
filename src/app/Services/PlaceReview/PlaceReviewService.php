<?php

namespace App\Services\PlaceReview;

use App\DTO\In\PlaceReview\CreatePlaceReviewDto;
use App\DTO\In\PlaceReview\GetPlaceReviewsDto;
use App\DTO\Out\PlaceReview\PlaceReviewDto;
use App\Exceptions\PlaceReview\FailedToCreatePlaceReview;
use App\Repositories\PlaceReview\Interfaces\IPlaceReviewRepository;
use App\Services\PlaceReview\Interfaces\IPlaceReviewService;
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
        $review = $this->reviewRepository->create([
            'author_id' => $createReviewDto->userId,
            'place_id' => $createReviewDto->placeId,
            'text' => $createReviewDto->text,
            'rating' => $createReviewDto->rating
        ]);
        return PlaceReviewDto::fromReviewModel($review);
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
