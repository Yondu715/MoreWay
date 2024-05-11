<?php

namespace App\Utils\Mappers\Out\Achievement;

use App\Application\DTO\Collection\CursorDto;
use App\Application\DTO\Out\Achievement\UserAchievementDto;
use App\Infrastructure\Database\Models\UserAchievementProgress;
use App\Utils\Mappers\Collection\CursorDtoMapper;
use Illuminate\Pagination\CursorPaginator;

class UserAchievementDtoMapper
{
    /**
     * @param UserAchievementProgress $userAchievementProgress
     * @return UserAchievementDto
     */
    public static function fromAchievementModel(UserAchievementProgress $userAchievementProgress): UserAchievementDto
    {
        return new UserAchievementDto(
            achievement: AchievementDtoMapper::fromAchievementModel($userAchievementProgress->achievement),
            currentProgress: $userAchievementProgress->progress,
        );
    }

    /**
     * @param CursorPaginator $paginator
     * @return CursorDto
     */
    public static function fromPaginator(CursorPaginator $paginator): CursorDto
    {
        return CursorDtoMapper::fromPaginatorAndMapper($paginator, function (UserAchievementProgress $userAchievementProgress) {
            return self::fromAchievementModel($userAchievementProgress);
        });
    }
}
