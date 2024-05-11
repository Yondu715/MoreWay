<?php

namespace App\Application\Contracts\In\Services\Rating;

use App\Application\DTO\Collection\CursorDto;
use App\Application\DTO\In\Rating\GetRatingDto;

interface IRatingService
{
    /**
     * @param GetRatingDto $getRatingDto
     * @return CursorDto
     */
    public function getRating(GetRatingDto $getRatingDto): CursorDto;
}
