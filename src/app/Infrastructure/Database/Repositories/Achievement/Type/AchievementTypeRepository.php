<?php

namespace App\Infrastructure\Database\Repositories\Achievement\Type;

use App\Application\Contracts\Out\Repositories\Achievement\Type\IAchievementTypeRepository;
use App\Application\DTO\Collection\CursorDto;
use App\Application\DTO\In\Achievements\Type\GetAchievementsTypesDto;
use App\Infrastructure\Database\Models\AchievementType;
use App\Utils\Mappers\Out\Achievement\Type\AchievementTypeDtoMapper;
use Illuminate\Database\Eloquent\Model;

class AchievementTypeRepository implements IAchievementTypeRepository
{
    private readonly Model $model;

    public function __construct(AchievementType $achievementType)
    {
        $this->model = $achievementType;
    }

    /**
     * @param GetAchievementsTypesDto $getAchievementsTypesDto
     * @return CursorDto
     */
    public function getAll(GetAchievementsTypesDto $getAchievementsTypesDto): CursorDto
    {
        $paginator = $this->model->query()
            ->cursorPaginate(perPage: $getAchievementsTypesDto->limit , cursor: $getAchievementsTypesDto->cursor);
        return AchievementTypeDtoMapper::fromPaginator($paginator);
    }
}
