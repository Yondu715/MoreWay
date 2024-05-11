<?php

namespace App\Utils\Mappers\Out\Achievement\Type;

use App\Application\DTO\Collection\CursorDto;
use App\Application\DTO\Out\Achievement\Type\AchievementTypeDto;
use App\Infrastructure\Database\Models\AchievementType;
use App\Utils\Mappers\Collection\CursorDtoMapper;
use Illuminate\Pagination\CursorPaginator;

class AchievementTypeDtoMapper
{
    /**
     * @param AchievementType $achievementType
     * @return AchievementTypeDto
     */
    public static function fromAchievementTypeModel(AchievementType $achievementType): AchievementTypeDto
    {
        return new AchievementTypeDto(
            id: $achievementType->id,
            name: $achievementType->name,
            value: $achievementType->value
        );
    }

    /**
     * @param CursorPaginator $paginator
     * @return CursorDto
     */
    public static function fromPaginator(CursorPaginator $paginator): CursorDto
    {
        return CursorDtoMapper::fromPaginatorAndMapper($paginator, function (AchievementType $achievementType) {
            return self::fromAchievementTypeModel($achievementType);
        });
    }
}
