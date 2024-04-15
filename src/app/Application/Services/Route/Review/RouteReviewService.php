<?php

namespace App\Application\Services\Route\Review;

use App\Application\Contracts\In\Services\Route\Review\IRouteReviewService;
use App\Application\Contracts\Out\Repositories\Route\Review\IRouteReviewRepository;
use App\Application\DTO\Collection\CursorDto;
use App\Application\DTO\In\Route\Review\CreateRouteReviewDto;
use App\Application\DTO\In\Route\Review\GetRouteReviewsDto;
use App\Application\DTO\Out\Review\ReviewCursorDto;
use App\Application\DTO\Out\Review\ReviewDto;
use App\Application\Exceptions\Review\FailedToCreateReview;
use Throwable;

class RouteReviewService implements IRouteReviewService
{
    public function __construct(
        private readonly IRouteReviewRepository $reviewRepository
    ) {}

    /**
     * @param CreateRouteReviewDto $createReviewDto
     * @return ReviewDto
     * @throws FailedToCreateReview
     */
    public function createReviews(CreateRouteReviewDto $createReviewDto): ReviewDto
    {
        try {
            $review = $this->reviewRepository->create([
                'author_id' => $createReviewDto->userId,
                'route_id' => $createReviewDto->routeId,
                'text' => $createReviewDto->text,
                'rating' => $createReviewDto->rating
            ]);
            return ReviewDto::fromReviewModel($review);
        } catch (Throwable) {
            throw new FailedToCreateReview();
        }
    }

    /**
     * @param GetRouteReviewsDto $getReviewsDto
     * @return CursorDto
     */
    public function getReviews(GetRouteReviewsDto $getReviewsDto): CursorDto
    {
        return ReviewCursorDto::fromPaginator($this->reviewRepository->getReviews($getReviewsDto));
    }
}
