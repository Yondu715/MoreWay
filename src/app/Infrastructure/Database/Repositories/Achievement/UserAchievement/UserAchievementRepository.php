<?php

namespace App\Infrastructure\Database\Repositories\Achievement\UserAchievement;

use App\Application\Contracts\Out\Repositories\Achievement\UserAchievement\IUserAchievementRepository;
use App\Application\DTO\Collection\CursorDto;
use App\Application\DTO\In\Achievements\GetUserAchievementsDto;
use App\Infrastructure\Database\Models\UserAchievementProgress;
use App\Utils\Mappers\Out\Achievement\UserAchievementDtoMapper;
use Illuminate\Database\Eloquent\Model;

class UserAchievementRepository implements IUserAchievementRepository
{

    private readonly Model $model;

    public function __construct(UserAchievementProgress $userAchievementProgress)
    {
        $this->model = $userAchievementProgress;
    }

    /**
     * @param GetUserAchievementsDto $getUserAchievementsDto
     * @return CursorDto
     */
    public function getAll(GetUserAchievementsDto $getUserAchievementsDto): CursorDto
    {
        //!!! and etc.
        $paginator = $this->model->query()
            ->where('user_id', $getUserAchievementsDto->userId)
            ->cursorPaginate(perPage: $getUserAchievementsDto->limit, cursor: $getUserAchievementsDto->cursor);
        return UserAchievementDtoMapper::fromPaginator($paginator);
    }
}