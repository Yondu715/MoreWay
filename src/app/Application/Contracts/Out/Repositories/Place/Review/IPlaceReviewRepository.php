<?php

namespace App\Application\Contracts\Out\Repositories\Place\Review;

use App\Application\Contracts\Out\Repositories\Base\IBaseRepository;
use App\Application\DTO\In\Place\Review\GetPlaceReviewsDto;
use App\Application\Exceptions\Review\FailedToCreateReview;
use App\Infrastructure\Database\Models\PlaceReview;
use Illuminate\Contracts\Pagination\CursorPaginator;

interface IPlaceReviewRepository extends IBaseRepository
{
    /**
     * @param GetPlaceReviewsDto $getReviewsDto
     * @return CursorPaginator
     */
    public function getReviews(GetPlaceReviewsDto $getReviewsDto): CursorPaginator;

    /**
     * @param array $attributes
     * @return PlaceReview
     * @throws FailedToCreateReview
     */
    public function create(array $attributes): PlaceReview;
}
