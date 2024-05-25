<?php

namespace App\Application\Contracts\Out\Repositories\Achievement\UserAchievement;

use App\Application\DTO\Collection\CursorDto;
use App\Application\DTO\In\Achievements\GetUserAchievementsDto;

interface IUserAchievementRepository
{
    /**
     * @param GetUserAchievementsDto $getUserAchievementsDto
     * @return CursorDto
     */
    public function getAll(GetUserAchievementsDto $getUserAchievementsDto): CursorDto;
}