<?php

namespace App\Infrastructure\Database\Models\Infrastructure\Database\Models\Application\DTO\Out\Friend;

use App\Infrastructure\Database\Models\Infrastructure\Database\Models\Application\DTO\Out\Auth\UserDto;
use App\Infrastructure\Database\Models\Infrastructure\Database\Models\Infrastructure\Database\Models\Friendship;

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

    /**
     * @param Friendship $friend
     * @return FriendshipRequestDto
     */
    public static function fromFriendModule(Friendship $friend): FriendshipRequestDto
    {
        return new self(
            id: $friend->id,
            user: UserDto::fromUserModel($friend->user)
        );
    }
}
