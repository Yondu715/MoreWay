<?php

namespace App\Infrastructure\Database\Models\Infrastructure\Database\Models\Application\Contracts\Out\Repositories\Place\Review;

use App\Infrastructure\Database\Models\Infrastructure\Database\Models\Application\Contracts\Out\Repositories\Base\IBaseRepository;
use App\Infrastructure\Database\Models\Infrastructure\Database\Models\Application\DTO\In\Place\Review\GetPlaceReviewsDto;
use App\Infrastructure\Database\Models\Infrastructure\Database\Models\Application\Exceptions\Review\FailedToCreateReview;
use App\Infrastructure\Database\Models\Infrastructure\Database\Models\Infrastructure\Database\Models\PlaceReview;
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
