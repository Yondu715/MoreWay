<?php

namespace App\Utils\Mappers\Out\Friend;

use App\Application\DTO\Collection\CursorDto;
use App\Application\DTO\Out\Friend\FriendshipDto;
use App\Infrastructure\Database\Models\Friendship;
use App\Utils\Mappers\Collection\CursorDtoMapper;
use App\Utils\Mappers\Out\User\UserDtoMapper;
use Illuminate\Contracts\Pagination\CursorPaginator;

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


    /**
     * @param CursorPaginator $cursorPaginator
     * @return CursorDto
     */
    public static function fromPaginator(CursorPaginator $cursorPaginator): CursorDto
    {
        return CursorDtoMapper::fromPaginatorAndMapper($cursorPaginator, function (Friendship $friendship) {
            return static::fromFriendshipModel($friendship);
        });
    }
}
