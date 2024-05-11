<?php

namespace App\Application\Services\Achievement;

use App\Application\Contracts\In\Services\Achievement\IAchievementService;
use App\Application\Contracts\Out\Repositories\Achievement\IAchievementRepository;
use App\Application\Contracts\Out\Repositories\Achievement\Type\IAchievementTypeRepository;
use App\Application\DTO\Collection\CursorDto;
use App\Application\DTO\In\Achievements\GetAchievementsDto;
use App\Application\DTO\In\Achievements\GetUserAchievementsDto;
use App\Application\DTO\In\Achievements\Type\GetAchievementsTypesDto;

class AchievementService implements IAchievementService
{
    public function __construct(
        private readonly IAchievementRepository $achievementRepository,
        private readonly IAchievementTypeRepository $achievementTypeRepository,
    ) {}

    /**
     * @param GetAchievementsDto $getAchievementsDto
     * @return CursorDto
     */
    public function getAchievements(GetAchievementsDto $getAchievementsDto): CursorDto
    {
        return $this->achievementRepository->getAll($getAchievementsDto);
    }

    /**
     * @param GetUserAchievementsDto $getUserAchievementsDto
     * @return CursorDto
     */
    public function getUserAchievements(GetUserAchievementsDto $getUserAchievementsDto): CursorDto
    {
        return $this->achievementRepository->getAllForUser($getUserAchievementsDto);
    }

    /**
     * @param GetAchievementsTypesDto $getAchievementsTypesDto
     * @return CursorDto
     */
    public function getAchievementsTypes(GetAchievementsTypesDto $getAchievementsTypesDto): CursorDto
    {
        return $this->achievementTypeRepository->getAll($getAchievementsTypesDto);
    }
}
