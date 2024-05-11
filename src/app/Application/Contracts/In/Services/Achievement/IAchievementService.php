<?php

namespace App\Application\Contracts\In\Services\Achievement;

use App\Application\DTO\Collection\CursorDto;
use App\Application\DTO\In\Achievements\GetAchievementsDto;
use App\Application\DTO\In\Achievements\GetUserAchievementsDto;
use App\Application\DTO\In\Achievements\Type\GetAchievementsTypesDto;

interface IAchievementService
{
    /**
     * @param GetAchievementsDto $getAchievementsDto
     * @return CursorDto
     */
    public function getAchievements(GetAchievementsDto $getAchievementsDto): CursorDto;

    /**
     * @param GetUserAchievementsDto $getUserAchievementsDto
     * @return CursorDto
     */
    public function getUserAchievements(GetUserAchievementsDto $getUserAchievementsDto): CursorDto;

    /**
     * @param GetAchievementsTypesDto $getAchievementsTypesDto
     * @return CursorDto
     */
    public function getAchievementsTypes(GetAchievementsTypesDto $getAchievementsTypesDto): CursorDto;
}
