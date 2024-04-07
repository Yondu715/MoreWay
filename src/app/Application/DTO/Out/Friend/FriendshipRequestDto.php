<?php

namespace App\Application\Dto\Out\Friend;

use App\Application\DTO\Out\Auth\UserDto;
use App\Infrastructure\Database\Models\Friend;

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

    public static function fromFriendModule(Friend $friend) {
        return new self(
            id: $friend->id,
            user: UserDto::fromUserModel($friend->user)
        );
    }
}
