<?php

namespace App\Application\Dto\Out\Rating;

use App\Application\DTO\Out\User\UserDto;

class ExtendedRatingDto
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