<?php

namespace App\Utils\Mappers\Out\Friend;

use App\Application\DTO\Out\Friend\FriendshipRequestDto;
use App\Infrastructure\Database\Models\Friendship;
use App\Utils\Mappers\Out\User\UserDtoMapper;

class FriendshipRequestDtoMapper
{
    /**
     * @param Friendship $friendship
     * @return FriendshipRequestDto
     */
    public static function fromFriendshipModel(Friendship $friendship): FriendshipRequestDto
    {
        return new FriendshipRequestDto(
            id: $friendship->id,
            userId: $friendship->user_id,
            friendId: $friendship->friend_id,
            user: UserDtoMapper::fromUserModel($friendship->user),
            friend: UserDtoMapper::fromUserModel($friendship->friend),
            type: RelationshipTypeDtoMapper::fromFriendRelationshipTypeModel($friendship->relationship)
        );
    }
}
