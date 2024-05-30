<?php

namespace App\Infrastructure\Database\Repositories\Rating;

use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;
use App\Application\DTO\Out\Rating\RatingDto;
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
     * @return Collection<int, RatingDto>
     */
    public function getLeaders(): Collection
    {
        $leaders = $this->model->query()
            ->with('user')
            ->selectRaw('*, ROW_NUMBER() OVER (ORDER BY score DESC) as position')
            ->limit(5)
            ->get();

        return $leaders->map(
            fn (UserScore $userScore) => RatingDtoMapper::fromUserScoreModel($userScore)
        );
    }

    /**
     * @param int $userId
     * @return RatingDto
     */
    public function getRatingByUserId(int $userId): RatingDto
    {
        $userRating = $this->model->query()->firstWhere('user_id', $userId);

        $userRatingWithPosition = $this->model->query()
            ->orderByDesc('score')
            ->selectRaw("*, (
                    SELECT COUNT(*) + 1
                    FROM {$this->model->getTable()}
                    WHERE {$this->model->getTable()}.score > $userRating->score
                ) AS position")
            ->where('user_id', $userId)
            ->first();

        return RatingDtoMapper::fromUserScoreModel($userRatingWithPosition);
    }
}
