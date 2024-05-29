<?php

namespace App\Application\Contracts\Out\Repositories\Rating;

use Illuminate\Support\Collection;
use App\Application\DTO\In\Rating\GetRatingDto;
use App\Application\DTO\Out\Rating\RatingDto;

interface IRatingRepository
{
    /**
     * @param GetRatingDto $getAchievementsDto
     * @return Collection<int, RatingDto>
     */
    public function getAll(GetRatingDto $getAchievementsDto): Collection;
}
