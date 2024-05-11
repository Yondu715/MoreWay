<?php

namespace App\Utils\Mappers\Out\Achievement;

use App\Application\DTO\Collection\CursorDto;
use App\Application\DTO\Out\Achievement\AchievementDto;
use App\Infrastructure\Database\Models\Achievement;
use App\Utils\Mappers\Collection\CursorDtoMapper;
use Illuminate\Pagination\CursorPaginator;

class AchievementDtoMapper
{
    /**
     * @param Achievement $achievement
     * @return AchievementDto
     */
    public static function fromAchievementModel(Achievement $achievement): AchievementDto
    {
        return new AchievementDto(
            id: $achievement->id,
            name: $achievement->name,
            target: $achievement->target,
            description: $achievement->description,
            type: $achievement->type,
            image: $achievement->image,
        );
    }

    /**
     * @param CursorPaginator $paginator
     * @return CursorDto
     */
    public static function fromPaginator(CursorPaginator $paginator): CursorDto
    {
        return CursorDtoMapper::fromPaginatorAndMapper($paginator, function (Achievement $achievement) {
            return self::fromAchievementModel($achievement);
        });
    }
}
