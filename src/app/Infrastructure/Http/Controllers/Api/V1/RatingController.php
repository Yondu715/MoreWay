<?php

namespace App\Infrastructure\Http\Controllers\Api\V1;

use App\Application\Contracts\In\Services\Rating\IRatingService;
use App\Infrastructure\Http\Requests\Rating\GetRatingRequest;
use App\Infrastructure\Http\Resources\Rating\RatingCursorResource;
use App\Utils\Mappers\In\Rating\GetRatingDtoMapper;

class RatingController
{
    public function __construct(
        private readonly IRatingService $ratingService,
    ) {}
    /**
     * @param GetRatingRequest $getRatingRequest
     * @return RatingCursorResource
     */
    public function getRating(GetRatingRequest $getRatingRequest): RatingCursorResource
    {
        $getAchievementsDto = GetRatingDtoMapper::fromRequest($getRatingRequest);
        return RatingCursorResource::make(
            $this->ratingService->getRating($getAchievementsDto)
        );
    }
}
