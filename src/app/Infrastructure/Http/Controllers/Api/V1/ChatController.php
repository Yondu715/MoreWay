<?php

namespace App\Infrastructure\Http\Controllers\Api\V1;

use App\Application\Contracts\In\Services\Chat\IChatService;
use App\Application\Exceptions\Chat\FailedToCreateChat;
use App\Infrastructure\Exceptions\ApiException;
use App\Infrastructure\Http\Requests\Chat\CreateChatRequest;
use App\Infrastructure\Http\Resources\Chat\ChatResource;
use App\Utils\Mappers\In\Chat\CreateChatDtoMapper;

class ChatController
{
    public function __construct(
        private readonly IChatService $chatService,
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
}
