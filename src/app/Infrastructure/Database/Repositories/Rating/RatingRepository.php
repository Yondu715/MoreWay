<?php

namespace App\Infrastructure\Database\Repositories\Rating;

use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;
use App\Application\DTO\In\Rating\GetRatingDto;
use App\Infrastructure\Database\Models\UserScore;
use App\Utils\Mappers\Out\Rating\RatingDtoMapper;
use App\Application\Contracts\Out\Repositories\Rating\IRatingRepository;

class RatingRepository implements IRatingRepository
{
    private readonly Model $model;

    public function __construct(UserScore $userScore)
    {
        $this->model = $userScore;
    }

    /**
     * @param GetRatingDto $getAchievementsDto
     * @return Collection
     */
    public function getAll(GetRatingDto $getAchievementsDto): Collection
    {
        $rating = $this->model->query()
            ->with('user')
            ->orderBy('score', 'desc')
            ->get();
        return $rating->map(function (UserScore $userScore) {
            return RatingDtoMapper::fromUserScoreModel($userScore);
        });
    }
}
