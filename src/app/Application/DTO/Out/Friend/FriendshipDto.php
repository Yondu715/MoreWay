<?php

namespace App\Application\DTO\Out\Friend;

use App\Application\Dto\Out\Friend\RelationshipTypeDto;
use App\Application\DTO\Out\User\UserDto;

class FriendshipDto
{
    public readonly int $id;
    public readonly UserDto $user;
    public readonly UserDto $friend;
    public readonly int $userId;
    public readonly int $friendId;
    public readonly RelationshipTypeDto $type;

    public function __construct(
        int $id,
        int $userId,
        int $friendId,
        UserDto $user,
        UserDto $friend,
        RelationshipTypeDto $type
    ) {
        $this->id = $id;
        $this->userId = $userId;
        $this->friendId = $friendId;
        $this->user = $user;
        $this->friend = $friend;
        $this->type = $type;
    }
}
