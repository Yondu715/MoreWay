<?php

namespace App\Application\DTO\Out\Rating;

use App\Application\DTO\Out\User\UserDto;

class RatingDto
{
    public readonly UserDto $user;
    public readonly int $score;

    public function __construct(
        UserDto $user,
        int $score,
    ) {
        $this->user = $user;
        $this->score = $score;
    }
}
