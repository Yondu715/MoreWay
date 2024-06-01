<?php

namespace App\Utils\Mappers\Out\Friend;

use App\Application\DTO\Out\Friend\FriendshipDto;
use App\Infrastructure\Database\Models\Friendship;
use App\Utils\Mappers\Out\User\UserDtoMapper;

class FriendshipDtoMapper
{
    /**
     * @param Friendship $friendship
     * @return FriendshipDto
     */
    public static function fromFriendshipModel(Friendship $friendship): FriendshipDto
    {
        return new FriendshipDto(
            id: $friendship->id,
            userId: $friendship->user_id,
            friendId: $friendship->friend_id,
            user: UserDtoMapper::fromUserModel($friendship->user),
            friend: UserDtoMapper::fromUserModel($friendship->friend),
            type: RelationshipTypeDtoMapper::fromFriendRelationshipTypeModel($friendship->relationship)
        );
    }
}
