<?php

namespace App\Utils\Mappers\In\Friend;

use App\Application\DTO\In\Friend\GetFriendRequestsDto;
use App\Infrastructure\Http\Requests\Friend\GetFriendRequestsRequest;

class GetFriendRequestsDtoMapper
{


    /**
     * @param GetFriendRequestsRequest $getFriendRequestsRequest
     * @return GetFriendRequestsDto
     */
    public static function fromRequest(GetFriendRequestsRequest $getFriendRequestsRequest): GetFriendRequestsDto
    {
        return new GetFriendRequestsDto(
            userId: $getFriendRequestsRequest->route('userId'),
            cursor: $getFriendRequestsRequest->cursor,
            limit: $getFriendRequestsRequest->limit
        );
    }
}