<?php

namespace App\Utils\Mappers\In\Friend;

use App\Application\DTO\In\Friend\AcceptFriendDto;
use App\Infrastructure\Http\Requests\Friend\AcceptFriendRequest;

class AcceptFriendDtoMapper
{
    /**
     * @param AcceptFriendRequest $acceptFriendRequest
     * @return AcceptFriendDto
     */
    public static function fromRequest(AcceptFriendRequest $acceptFriendRequest): AcceptFriendDto
    {
        return new AcceptFriendDto(
            requestId: $acceptFriendRequest->requestId
        );
    }
}