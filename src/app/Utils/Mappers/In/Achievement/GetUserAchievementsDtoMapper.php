<?php

namespace App\Utils\Mappers\In\Achievement;

use App\Application\DTO\In\Achievements\GetUserAchievementsDto;
use App\Infrastructure\Http\Requests\Achievement\GetUserAchievementsRequest;

class GetUserAchievementsDtoMapper
{
    /**
     * @param GetUserAchievementsRequest $getUserAchievementsRequest
     * @return GetUserAchievementsDto
     */
    public static function fromRequest(GetUserAchievementsRequest $getUserAchievementsRequest): GetUserAchievementsDto
    {
        return new GetUserAchievementsDto(
            userId: (int)$getUserAchievementsRequest->route('userId'),
            cursor: $getUserAchievementsRequest->cursor,
            limit: $getUserAchievementsRequest->limit
        );
    }
}
