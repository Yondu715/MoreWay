<?php

namespace App\Application\Services\Chat;

use App\Application\Contracts\In\Services\Chat\IChatService;
use App\Application\Contracts\Out\Repositories\Chat\IChatRepository;
use App\Application\DTO\Collection\CursorDto;
use App\Application\DTO\In\Chat\CreateChatDto;
use App\Application\DTO\In\Chat\GetUserChatsDto;
use App\Application\DTO\Out\Chat\ChatDto;
use App\Application\Exceptions\Chat\FailedToCreateChat;

class ChatService implements IChatService
{
    public function __construct(
        private readonly IChatRepository $chatRepository
    ) {}

    /**
     * @param GetUserChatsDto $getUserChatsDto
     * @return CursorDto
     */
    public function getUserChats(GetUserChatsDto $getUserChatsDto): CursorDto
    {
        return $this->chatRepository->getUserChats($getUserChatsDto);
    }

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
