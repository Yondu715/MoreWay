<?php

namespace App\Application\DTO\In\Friend;

class AddFriendDto
{
    public readonly int $userId;
    public readonly int $friendId;

    public function __construct(
        int $userId,
        int $friendId
    ) {
        $this->userId = $userId;
        $this->friendId = $friendId;
    }

}
