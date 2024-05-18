<?php

namespace App\Utils\Mappers\In\Chat\Message;

use App\Application\DTO\In\Chat\Message\AddMessageDto;
use App\Infrastructure\Http\Requests\Chat\Message\AddMessageRequest;

class AddMessageDtoMapper
{
    /**
     * @param AddMessageRequest $addMessageRequest
     * @return AddMessageDto
     */
    public static function fromRequest(AddMessageRequest $addMessageRequest): AddMessageDto
    {
        return new AddMessageDto(
            chatId: $addMessageRequest->route('chatId'),
            senderId: $addMessageRequest->userId,
            message: $addMessageRequest->message
        );
    }
}
