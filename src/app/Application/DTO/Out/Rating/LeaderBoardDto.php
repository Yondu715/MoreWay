<?php

namespace App\Application\DTO\Out\Rating;

use Illuminate\Support\Collection;
use App\Application\DTO\Out\Rating\RatingDto;

class LeaderBoardDto
{
    public readonly Collection $leaders;
    public readonly RatingDto $userRating;

    public function __construct(
        Collection $leaders,
        RatingDto $userRating
    )
    {
        $this->leaders = $leaders;
        $this->userRating = $userRating;
    }
}