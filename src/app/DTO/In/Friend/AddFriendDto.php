<?php

namespace App\DTO\In\Friend;

use App\Http\Requests\Friend\AddFriendRequest;

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

    public static function fromRequest(AddFriendRequest $addFriendRequest): self
    {
        return new self(
            userId: $addFriendRequest->userId,
            friendId: $addFriendRequest->friendId
        );
    }
}
