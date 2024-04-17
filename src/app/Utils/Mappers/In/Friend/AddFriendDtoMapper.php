<?php

namespace App\Utils\Mappers\In\Friend;

use App\Application\DTO\In\Friend\AddFriendDto;
use App\Infrastructure\Http\Requests\Friend\AddFriendRequest;

class AddFriendDtoMapper
{
    /**
     * @param AddFriendRequest $addFriendRequest
     * @return AddFriendDto
     */
    public static function fromRequest(AddFriendRequest $addFriendRequest): AddFriendDto
    {
        return new AddFriendDto(
            userId: $addFriendRequest->userId,
            friendId: $addFriendRequest->friendId
        );
    }
}