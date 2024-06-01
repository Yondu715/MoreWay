<?php

namespace App\Application\Contracts\In\Services\Rating;

use App\Application\DTO\In\Rating\GetRatingDto;
use App\Application\DTO\Out\Rating\LeaderBoardDto;

interface IRatingService
{
    /**
     * @param GetRatingDto $getRatingDto
     * @return LeaderBoardDto
     */
    public function getRating(GetRatingDto $getRatingDto): LeaderBoardDto;
}
