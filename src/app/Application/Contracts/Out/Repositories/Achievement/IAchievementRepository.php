<?php

namespace App\Application\Contracts\Out\Repositories\Achievement;

use App\Application\DTO\Collection\CursorDto;
use App\Application\DTO\In\Achievements\GetAchievementsDto;
use App\Application\DTO\In\Achievements\GetUserAchievementsDto;

interface IAchievementRepository
{
    /**
     * @param GetAchievementsDto $getAchievementsDto
     * @return CursorDto
     */
    public function getAll(GetAchievementsDto $getAchievementsDto): CursorDto;

    /**
     * @param GetUserAchievementsDto $getUserAchievementsDto
     * @return CursorDto
     */
    public function getAllForUser(GetUserAchievementsDto $getUserAchievementsDto): CursorDto;
}
