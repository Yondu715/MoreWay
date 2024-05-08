<?php

namespace App\Application\DTO\Out\Friend;

use App\Application\DTO\Out\Auth\UserDto;

class FriendshipRequestDto
{
    public readonly int $id;
    public readonly UserDto $user;
    public readonly UserDto $friend;
    public readonly int $userId;
    public readonly int $friendId;

    public function __construct(
        int $id,
        int $userId,
        int $friendId,
        UserDto $user,
        UserDto $friend
    ) {
        $this->id = $id;
        $this->userId = $userId;
        $this->friendId = $friendId;
        $this->user = $user;
        $this->friend = $friend;
    }

}
