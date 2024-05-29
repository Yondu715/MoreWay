<?php

namespace App\Application\Dto\Out\Rating;

use Illuminate\Support\Collection;

class LeaderBoardDto
{
    public readonly Collection $leaders;
    public readonly ExtendedRatingDto $userRating;

    public function __construct(
        Collection $leaders,
        ExtendedRatingDto $userRating
    )
    {
        $this->leaders = $leaders;
        $this->userRating = $userRating;
    }
}