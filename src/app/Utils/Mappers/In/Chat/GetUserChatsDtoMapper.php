<?php

namespace App\Utils\Mappers\In\Chat;

use App\Application\DTO\In\Chat\GetUserChatsDto;
use App\Infrastructure\Http\Requests\Chat\GetUserChatsRequest;

class GetUserChatsDtoMapper
{
    /**
     * @param GetUserChatsRequest $getUserChatsRequest
     * @return GetUserChatsDto
     */
    public static function fromRequest(GetUserChatsRequest $getUserChatsRequest): GetUserChatsDto
    {
        return new GetUserChatsDto(
            userId: $getUserChatsRequest->route('userId'),
            cursor: $getUserChatsRequest->cursor,
            limit: $getUserChatsRequest->limit ?? 2
        );
    }
}
