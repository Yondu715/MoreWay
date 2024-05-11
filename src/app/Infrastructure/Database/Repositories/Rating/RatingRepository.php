<?php

namespace App\Infrastructure\Database\Repositories\Rating;

use App\Application\Contracts\Out\Repositories\Rating\IRatingRepository;
use App\Application\DTO\Collection\CursorDto;
use App\Application\DTO\In\Rating\GetRatingDto;
use App\Infrastructure\Database\Models\UserScore;
use App\Utils\Mappers\Out\Rating\RatingDtoMapper;
use Illuminate\Database\Eloquent\Model;

class RatingRepository implements IRatingRepository
{
    private readonly Model $model;

    public function __construct(UserScore $userScore)
    {
        $this->model = $userScore;
    }

    /**
     * @param GetRatingDto $getAchievementsDto
     * @return CursorDto
     */
    public function getAll(GetRatingDto $getAchievementsDto): CursorDto
    {
        $paginator = $this->model->query()
            ->orderBy('score', 'desc')
            ->cursorPaginate(perPage: $getAchievementsDto->limit , cursor: $getAchievementsDto->cursor);
        return RatingDtoMapper::fromPaginator($paginator);
    }
}
