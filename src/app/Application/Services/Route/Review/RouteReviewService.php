<?php

namespace App\Application\Services\Route\Review;

use App\Application\Contracts\In\Services\Route\Review\IRouteReviewService;
use App\Application\Contracts\Out\Repositories\Route\Review\IRouteReviewRepository;
use App\Application\DTO\Collection\CursorDto;
use App\Application\DTO\In\Route\Review\CreateRouteReviewDto;
use App\Application\DTO\In\Route\Review\GetRouteReviewsDto;
use App\Application\DTO\Out\Review\ReviewDto;
use App\Application\Exceptions\Review\FailedToCreateReview;

class RouteReviewService implements IRouteReviewService
{
    public function __construct(
        private readonly IRouteReviewRepository $reviewRepository
    ) {
    }

    /**
     * @param CreateRouteReviewDto $createReviewDto
     * @return ReviewDto
     * @throws FailedToCreateReview
     */
    public function createReviews(CreateRouteReviewDto $createReviewDto): ReviewDto
    {
        return $this->reviewRepository->create([
            'author_id' => $createReviewDto->userId,
            'route_id' => $createReviewDto->routeId,
            'text' => $createReviewDto->text,
            'rating' => $createReviewDto->rating
        ]);
    }

    /**
     * @param GetRouteReviewsDto $getReviewsDto
     * @return CursorDto
     */
    public function getReviews(GetRouteReviewsDto $getReviewsDto): CursorDto
    {
        return $this->reviewRepository->getAll($getReviewsDto);
    }
}
