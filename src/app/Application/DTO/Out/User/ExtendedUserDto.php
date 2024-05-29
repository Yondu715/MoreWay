<?php

namespace App\Application\Dto\Out\User;

use App\Application\DTO\Out\User\UserDto;

class ExtendedUserDto
{
    public readonly UserDto $user;
    public readonly ?bool $isFriend;
    public readonly ?int $score;

    public function __construct(
        UserDto $user,
        ?bool $isFriend = null,
        ?int $score = null
    )
    {
        $this->user = $user;
        $this->isFriend = $isFriend;
        $this->score = $score;
    }
}