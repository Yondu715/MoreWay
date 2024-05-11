<?php

namespace App\Application\Contracts\Out\Repositories\Rating;

use App\Application\DTO\Collection\CursorDto;
use App\Application\DTO\In\Rating\GetRatingDto;

interface IRatingRepository
{
    /**
     * @param GetRatingDto $getAchievementsDto
     * @return CursorDto
     */
    public function getAll(GetRatingDto $getAchievementsDto): CursorDto;
}
