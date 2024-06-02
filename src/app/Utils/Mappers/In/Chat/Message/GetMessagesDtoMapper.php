<?php

namespace App\Utils\Mappers\In\Chat\Message;

use App\Application\DTO\In\Chat\Message\GetMessagesDto;
use App\Infrastructure\Http\Requests\Chat\Message\GetMessagesRequest;

class GetMessagesDtoMapper
{
    /**
     * @param GetMessagesRequest $getMessagesRequest
     * @return GetMessagesDto
     */
    public static function fromRequest(GetMessagesRequest $getMessagesRequest): GetMessagesDto
    {
        return new GetMessagesDto(
            chatId: $getMessagesRequest->route('chatId'),
            cursor: $getMessagesRequest->cursor,
            limit: $getMessagesRequest->limit
        );
    }
}
