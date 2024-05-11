<?php

namespace App\Infrastructure\Http\Controllers\Api\V1;

use App\Application\Contracts\In\Services\Achievement\IAchievementService;
use App\Infrastructure\Http\Controllers\Controller;
use App\Infrastructure\Http\Requests\Achievement\GetAchievementsRequest;
use App\Infrastructure\Http\Requests\Achievement\GetUserAchievementsRequest;
use App\Infrastructure\Http\Requests\Achievement\Type\GetAchievementsTypesRequest;
use App\Infrastructure\Http\Resources\Achievement\AchievementCursorResource;
use App\Infrastructure\Http\Resources\Achievement\Type\AchievementTypeCursorResource;
use App\Infrastructure\Http\Resources\Achievement\UserAchievementCursorResource;
use App\Utils\Mappers\In\Achievement\GetAchievementsDtoMapper;
use App\Utils\Mappers\In\Achievement\GetUserAchievementsDtoMapper;
use App\Utils\Mappers\In\Achievement\Type\GetAchievementsTypesDtoMapper;

class AchievementController extends Controller
{
    public function __construct(
        private readonly IAchievementService $achievementService,
    ) {}

    public function getAchievements (GetAchievementsRequest $getAchievementsRequest): AchievementCursorResource
    {
        $getAchievementsDto = GetAchievementsDtoMapper::fromRequest($getAchievementsRequest);
        return AchievementCursorResource::make(
            $this->achievementService->getAchievements($getAchievementsDto)
        );
    }

    public function getUserAchievements(GetUserAchievementsRequest $getUserAchievementsRequest): UserAchievementCursorResource
    {
        $getUserAchievementsDto = GetUserAchievementsDtoMapper::fromRequest($getUserAchievementsRequest);
        return UserAchievementCursorResource::make(
            $this->achievementService->getUserAchievements($getUserAchievementsDto)
        );
    }

    public function getAchievementsTypes(GetAchievementsTypesRequest $getAchievementsTypesRequest): AchievementTypeCursorResource
    {
        $getAchievementsTypesDto = GetAchievementsTypesDtoMapper::fromRequest($getAchievementsTypesRequest);
        return AchievementTypeCursorResource::make(
                $this->achievementService->getAchievementsTypes($getAchievementsTypesDto)
        );
    }
}
