<?php

namespace App\Infrastructure\Http\Controllers\Api\V1;

use App\Utils\Mappers\In\Rating\GetRatingDtoMapper;
use App\Infrastructure\Http\Requests\Rating\GetRatingRequest;
use App\Application\Contracts\In\Services\Rating\IRatingService;
use App\Infrastructure\Http\Resources\Rating\LeaderBoardResource;

class RatingController
{
    public function __construct(
        private readonly IRatingService $ratingService,
    ) {}

    /**
     * @param GetRatingRequest $getRatingRequest
     * @return LeaderBoardResource
     */
    public function getRating(GetRatingRequest $getRatingRequest): LeaderBoardResource
    {
        $getAchievementsDto = GetRatingDtoMapper::fromRequest($getRatingRequest);
        return LeaderBoardResource::make(
            $this->ratingService->getRating($getAchievementsDto)
        );
    }
}
