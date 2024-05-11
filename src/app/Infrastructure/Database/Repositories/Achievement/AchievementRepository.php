<?php

namespace App\Infrastructure\Database\Repositories\Achievement;

use App\Application\Contracts\Out\Repositories\Achievement\IAchievementRepository;
use App\Application\DTO\Collection\CursorDto;
use App\Application\DTO\In\Achievements\GetAchievementsDto;
use App\Application\DTO\In\Achievements\GetUserAchievementsDto;
use App\Infrastructure\Database\Models\Achievement;
use App\Infrastructure\Database\Models\UserAchievementProgress;
use App\Utils\Mappers\Out\Achievement\AchievementDtoMapper;
use App\Utils\Mappers\Out\Achievement\UserAchievementDtoMapper;
use Illuminate\Database\Eloquent\Model;

class AchievementRepository implements IAchievementRepository
{
    private readonly Model $model;

    public function __construct(Achievement $achievement)
    {
        $this->model = $achievement;
    }

    /**
     * @param GetAchievementsDto $getAchievementsDto
     * @return CursorDto
     */
    public function getAll(GetAchievementsDto $getAchievementsDto): CursorDto
    {
        $paginator = $this->model->query()
            ->cursorPaginate(perPage: $getAchievementsDto->limit , cursor: $getAchievementsDto->cursor);
        return AchievementDtoMapper::fromPaginator($paginator);
    }

    /**
     * @param GetUserAchievementsDto $getUserAchievementsDto
     * @return CursorDto
     */
    public function getAllForUser(GetUserAchievementsDto $getUserAchievementsDto): CursorDto
    {
        $paginator = UserAchievementProgress::query()
            ->where('user_id', $getUserAchievementsDto->userId)
            ->cursorPaginate(perPage: $getUserAchievementsDto->limit , cursor: $getUserAchievementsDto->cursor);
        return UserAchievementDtoMapper::fromPaginator($paginator);
    }
}
