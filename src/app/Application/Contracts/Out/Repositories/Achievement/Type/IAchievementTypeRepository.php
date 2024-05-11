<?php

namespace App\Application\Contracts\Out\Repositories\Achievement\Type;

use App\Application\DTO\Collection\CursorDto;
use App\Application\DTO\In\Achievements\Type\GetAchievementsTypesDto;

interface IAchievementTypeRepository
{
    /**
     * @param GetAchievementsTypesDto $getAchievementsTypesDto
     * @return CursorDto
     */
    public function getAll(GetAchievementsTypesDto $getAchievementsTypesDto): CursorDto;
}
