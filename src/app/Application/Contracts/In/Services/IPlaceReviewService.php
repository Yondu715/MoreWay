<?php

namespace App\Application\Contracts\In\Services;

use App\Application\DTO\In\Place\Review\CreatePlaceReviewDto;
use App\Application\DTO\In\Place\Review\GetPlaceReviewsDto;
use App\Application\DTO\Out\Place\Review\PlaceReviewDto;
use Illuminate\Contracts\Pagination\CursorPaginator;

interface IPlaceReviewService
{
    /**
     * @param CreatePlaceReviewDto $createReviewDto
     * @return PlaceReviewDto
     */
    public function createReviews(CreatePlaceReviewDto $createReviewDto): PlaceReviewDto;

    /**
     * @param GetPlaceReviewsDto $getReviewsDto
     * @return array{data:array<PlaceReviewDto>, next_cursor:string}
     */
    public function getReviews(GetPlaceReviewsDto $getReviewsDto): array;
}
