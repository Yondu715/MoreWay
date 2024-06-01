<?php

namespace App\Application\DTO\Out\User;

class ExtendedUserDto
{
    public readonly UserDto $user;
    public readonly ?string $relationship;
    public readonly ?int $score;

    public function __construct(
        UserDto $user,
        ?string $relationship = null,
        ?int $score = null
    )
    {
        $this->user = $user;
        $this->relationship = $relationship;
        $this->score = $score;
    }
}
