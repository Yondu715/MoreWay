<?php

namespace App\Infrastructure\Database\Models\Infrastructure\Database\Models\Application\Contracts\In\Services\Route\Review;

use App\Infrastructure\Database\Models\Infrastructure\Database\Models\Application\DTO\Collection\CursorDto;
use App\Infrastructure\Database\Models\Infrastructure\Database\Models\Application\DTO\In\Route\Review\CreateRouteReviewDto;
use App\Infrastructure\Database\Models\Infrastructure\Database\Models\Application\DTO\In\Route\Review\GetRouteReviewsDto;
use App\Infrastructure\Database\Models\Infrastructure\Database\Models\Application\DTO\Out\Review\ReviewDto;

interface IRouteReviewService
{
    /**
     * @param CreateRouteReviewDto $createReviewDto
     * @return ReviewDto
     */
    public function createReviews(CreateRouteReviewDto $createReviewDto): ReviewDto;

    /**
     * @param GetRouteReviewsDto $getReviewsDto
     * @return CursorDto
     */
    public function getReviews(GetRouteReviewsDto $getReviewsDto): CursorDto;
}
