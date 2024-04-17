<?php

namespace App\Application\DTO\Out\Friend;

use App\Application\DTO\Out\Auth\UserDto;

class FriendshipRequestDto
{
    public readonly int $id;
    public readonly UserDto $user;

    public function __construct(
        int $id,
        UserDto $user
    ) {
        $this->id = $id;
        $this->user = $user;
    }

}
