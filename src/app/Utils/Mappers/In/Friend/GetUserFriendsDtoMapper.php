<?php

namespace App\Utils\Mappers\In\Friend;

use App\Application\DTO\In\Friend\GetUserFriendsDto;
use App\Infrastructure\Http\Requests\Friend\GetUserFriendsRequest;

class GetUserFriendsDtoMapper
{

    /**
     * @param GetUserFriendsRequest $getUserFriendsRequest
     * @return GetUserFriendsDto
     */
    public static function fromRequest(GetUserFriendsRequest $getUserFriendsRequest): GetUserFriendsDto
    {
        return new GetUserFriendsDto(
            userId: $getUserFriendsRequest->route('userId'),
            cursor: $getUserFriendsRequest->cursor,
            limit: $getUserFriendsRequest->limit
        );
    }
}