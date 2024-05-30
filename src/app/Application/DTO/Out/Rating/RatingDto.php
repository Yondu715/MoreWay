<?php

namespace App\Application\DTO\Out\Rating;

use App\Application\DTO\Out\User\UserDto;

class RatingDto
{
    public readonly UserDto $user;
    public readonly int $score;
    public readonly int $position;

    public function __construct(
        UserDto $user,
        int $score,
        int $position
    ) {
        $this->user = $user;
        $this->score = $score;
        $this->position = $position;
    }
}
