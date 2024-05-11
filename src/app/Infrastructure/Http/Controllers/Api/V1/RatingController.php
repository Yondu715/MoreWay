<?php

namespace App\Infrastructure\Http\Controllers\Api\V1;

use App\Infrastructure\Http\Requests\Rating\GetRatingRequest;

class RatingController
{
    public function __construct(
        private readonly IRatingService $ratingService,
    ) {}
    /**
     * @param GetRatingRequest $getRatingRequest
     * @return RatingCursorResource
     */
    public function getAchievements (GetRatingRequest $getRatingRequest): RatingCursorResource
    {
        $getAchievementsDto = GetRatingDtoMapper::fromRequest($getRatingRequest);
        return RatingCursorResource::make(
            $this->ratingService->getAchievements($getAchievementsDto)
        );
    }
}
