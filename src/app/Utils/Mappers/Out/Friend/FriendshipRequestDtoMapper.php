<?php

namespace Src\App\Utils\Mappers\Out\Friend;

use App\Application\DTO\Out\Friend\FriendshipRequestDto;
use App\Infrastructure\Database\Models\Friendship;
use App\Utils\Mappers\Out\Auth\UserDtoMapper;

class FriendshipRequestDtoMapper
{
    /**
     * @param Friendship $friend
     * @return FriendshipRequestDto
     */
    public static function fromFriendshipModel(Friendship $friendship): FriendshipRequestDto
    {
        return new FriendshipRequestDto(
            id: $friendship->id,
            user: UserDtoMapper::fromUserModel($friendship->user)
        );
    }
}