<?php

namespace App\Utils\Mappers\In\Achievement\Type;

use App\Application\DTO\In\Achievements\Type\GetAchievementsTypesDto;
use App\Infrastructure\Http\Requests\Achievement\Type\GetAchievementsTypesRequest;

class GetAchievementsTypesDtoMapper
{
    /**
     * @param GetAchievementsTypesRequest $getAchievementsTypesRequest
     * @return GetAchievementsTypesDto
     */
    public static function fromRequest(GetAchievementsTypesRequest $getAchievementsTypesRequest): GetAchievementsTypesDto
    {
        return new GetAchievementsTypesDto(
            cursor: $getAchievementsTypesRequest->cursor,
            limit: $getAchievementsTypesRequest->limit
        );
    }
}
