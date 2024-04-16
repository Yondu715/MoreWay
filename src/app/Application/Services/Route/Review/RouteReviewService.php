<?php

namespace App\Infrastructure\Database\Models\Infrastructure\Database\Models\Application\Services\Route\Review;

use App\Infrastructure\Database\Models\Infrastructure\Database\Models\Application\Contracts\In\Services\Route\Review\IRouteReviewService;
use App\Infrastructure\Database\Models\Infrastructure\Database\Models\Application\Contracts\Out\Repositories\Route\Review\IRouteReviewRepository;
use App\Infrastructure\Database\Models\Infrastructure\Database\Models\Application\DTO\Collection\CursorDto;
use App\Infrastructure\Database\Models\Infrastructure\Database\Models\Application\DTO\In\Route\Review\CreateRouteReviewDto;
use App\Infrastructure\Database\Models\Infrastructure\Database\Models\Application\DTO\In\Route\Review\GetRouteReviewsDto;
use App\Infrastructure\Database\Models\Infrastructure\Database\Models\Application\DTO\Out\Review\ReviewCursorDto;
use App\Infrastructure\Database\Models\Infrastructure\Database\Models\Application\DTO\Out\Review\ReviewDto;
use App\Infrastructure\Database\Models\Infrastructure\Database\Models\Application\Exceptions\Review\FailedToCreateReview;
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
