<?php

namespace App\Infrastructure\Http\Controllers\Api\V1;

use App\Application\Contracts\In\Services\Chat\IChatService;
use App\Application\Contracts\In\Services\Chat\Message\IMessageService;
use App\Application\Exceptions\Chat\FailedToCreateChat;
use App\Application\Exceptions\Chat\Message\FailedToCreateMessage;
use App\Infrastructure\Exceptions\ApiException;
use App\Infrastructure\Http\Requests\Chat\CreateChatRequest;
use App\Infrastructure\Http\Requests\Chat\Message\AddMessageRequest;
use App\Infrastructure\Http\Resources\Chat\ChatResource;
use App\Infrastructure\Http\Resources\Chat\Message\MessageResource;
use App\Utils\Mappers\In\Chat\CreateChatDtoMapper;
use App\Utils\Mappers\In\Chat\Message\AddMessageDtoMapper;

class ChatController
{
    public function __construct(
        private readonly IChatService $chatService,
        private readonly IMessageService $messageService,
    ) {}

    /**
     * @param CreateChatRequest $createChatRequest
     * @return ChatResource
     * @throws ApiException
     */
    public function createChat(CreateChatRequest $createChatRequest): ChatResource
    {
        try {
            $createChatDto = CreateChatDtoMapper::fromRequest($createChatRequest);
            return ChatResource::make(
                $this->chatService->createChat($createChatDto)
            );
        } catch (FailedToCreateChat $e) {
            throw new ApiException($e->getMessage(), $e->getCode());
        }
    }

    /**
     * @param AddMessageRequest $addMessageRequest
     * @return MessageResource
     * @throws ApiException
     */
    public function addMessage(AddMessageRequest $addMessageRequest): MessageResource
    {
        try {
            $addMessageDto = AddMessageDtoMapper::fromRequest($addMessageRequest);
            return MessageResource::make(
                $this->messageService->createMessage($addMessageDto)
            );
        } catch (FailedToCreateMessage $e) {
            throw new ApiException($e->getMessage(), $e->getCode());
        }
    }
}
