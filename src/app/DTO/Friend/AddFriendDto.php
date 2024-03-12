<?php

namespace App\DTO\Friend;

use App\Http\Requests\Friend\AddFriendRequest;

class AddFriendDto
{
    public readonly int $userId;
    public readonly int $friendId;

    public static function fromRequest(AddFriendRequest $addFriendRequest): self
    {
        $dto = new self();

        $dto->userId = $addFriendRequest->userId;
        $dto->friendId = $addFriendRequest->friendId;
        return $dto;
    }
}
