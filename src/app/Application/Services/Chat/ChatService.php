<?php

namespace App\Application\Services\Chat;

use App\Application\Contracts\In\Services\Chat\IChatService;
use App\Application\Contracts\Out\Repositories\Chat\IChatRepository;
use App\Application\DTO\In\Chat\CreateChatDto;
use App\Application\DTO\Out\Chat\ChatDto;
use App\Application\Exceptions\Chat\FailedToCreateChat;

class ChatService implements IChatService
{
    public function __construct(
        private readonly IChatRepository $chatRepository
    ) {}

    /**
     * @param CreateChatDto $createChatDto
     * @return ChatDto
     * @throws FailedToCreateChat
     */
    public function createChat(CreateChatDto $createChatDto): ChatDto
    {
        return $this->chatRepository->create($createChatDto);
    }
}
