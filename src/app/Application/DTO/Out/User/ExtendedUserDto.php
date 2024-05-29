<?php

namespace App\Application\Dto\Out\User;

use App\Application\DTO\Out\User\UserDto;

class ExtendedUserDto
{
    public readonly UserDto $user;
    public readonly bool $isFriend;

    public function __construct(
        UserDto $user,
        bool $isFriend
    )
    {
        $this->user = $user;
        $this->isFriend = $isFriend;
    }
}