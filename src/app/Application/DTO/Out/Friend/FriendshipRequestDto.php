<?php

namespace App\Application\DTO\Out\Friend;

use App\Application\DTO\Out\Auth\UserDto;

class FriendshipRequestDto
{
    public readonly int $id;
    public readonly UserDto $user;
    public readonly int $userId;
    public readonly int $friendId;

    public function __construct(
        int $id,
        UserDto $user,
        int $userId,
        int $friendId
    ) {
        $this->id = $id;
        $this->user = $user;
        $this->userId = $userId;
        $this->friendId = $friendId;
    }

}
