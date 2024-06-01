<?php

namespace App\Infrastructure\Http\Controllers\Api\V1;

use App\Infrastructure\Http\Controllers\Controller;
use App\Utils\Mappers\In\Achievement\GetAchievementsDtoMapper;
use App\Utils\Mappers\In\Achievement\GetUserAchievementsDtoMapper;
use App\Infrastructure\Http\Requests\Achievement\GetAchievementsRequest;
use App\Utils\Mappers\In\Achievement\Type\GetAchievementsTypesDtoMapper;
use App\Application\Contracts\In\Services\Achievement\IAchievementService;
use App\Infrastructure\Http\Requests\Achievement\GetUserAchievementsRequest;
use App\Infrastructure\Http\Resources\Achievement\AchievementCursorResource;
use App\Infrastructure\Http\Requests\Achievement\Type\GetAchievementsTypesRequest;
use App\Infrastructure\Http\Resources\Achievement\Type\AchievementTypeCursorResource;
use App\Infrastructure\Http\Resources\Achievement\UserAchievement\UserAchievementCursorResource;

class AchievementController extends Controller
{
    public function __construct(
        private readonly IAchievementService $achievementService,
    ) {}

    /**
     * @param GetAchievementsRequest $getAchievementsRequest
     * @return AchievementCursorResource
     */
    public function getAchievements (GetAchievementsRequest $getAchievementsRequest): AchievementCursorResource
    {
        $getAchievementsDto = GetAchievementsDtoMapper::fromRequest($getAchievementsRequest);
        return AchievementCursorResource::make(
            $this->achievementService->getAchievements($getAchievementsDto)
        );
    }

    /**
     * @param GetUserAchievementsRequest $getUserAchievementsRequest
     * @return UserAchievementCursorResource
     */
    public function getUserAchievements(GetUserAchievementsRequest $getUserAchievementsRequest): UserAchievementCursorResource
    {
        $getUserAchievementsDto = GetUserAchievementsDtoMapper::fromRequest($getUserAchievementsRequest);
        return UserAchievementCursorResource::make(
            $this->achievementService->getUserAchievements($getUserAchievementsDto)
        );
    }

    /**
     * @param GetAchievementsTypesRequest $getAchievementsTypesRequest
     * @return AchievementTypeCursorResource
     */
    public function getAchievementsTypes(GetAchievementsTypesRequest $getAchievementsTypesRequest): AchievementTypeCursorResource
    {
        $getAchievementsTypesDto = GetAchievementsTypesDtoMapper::fromRequest($getAchievementsTypesRequest);
        return AchievementTypeCursorResource::make(
                $this->achievementService->getAchievementsTypes($getAchievementsTypesDto)
        );
    }
}
