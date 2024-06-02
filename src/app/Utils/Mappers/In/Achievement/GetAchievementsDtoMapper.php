<?php

namespace App\Utils\Mappers\In\Achievement;

use App\Application\DTO\In\Achievements\GetAchievementsDto;
use App\Infrastructure\Http\Requests\Achievement\GetAchievementsRequest;

class GetAchievementsDtoMapper
{
    /**
     * @param GetAchievementsRequest $getAchievementsRequest
     * @return GetAchievementsDto
     */
    public static function fromRequest(GetAchievementsRequest $getAchievementsRequest): GetAchievementsDto
    {
        return new GetAchievementsDto(
            cursor: $getAchievementsRequest->cursor,
            limit: $getAchievementsRequest->limit
        );
    }
}
