<?php

namespace App\Application\Services\Chat;

use App\Application\Contracts\In\Services\Chat\IChatService;
use App\Application\Contracts\Out\Managers\Notifier\INotifierManager;
use App\Application\Contracts\Out\Managers\Token\ITokenManager;
use App\Application\Contracts\Out\Repositories\Chat\IChatRepository;
use App\Application\DTO\Collection\CursorDto;
use App\Application\DTO\In\Chat\CreateChatDto;
use App\Application\DTO\In\Chat\GetUserChatsDto;
use App\Application\DTO\Out\Chat\ChatDto;
use App\Application\Exceptions\Chat\FailedToCreateChat;
use App\Infrastructure\Exceptions\Forbidden;
use App\Infrastructure\Exceptions\InvalidToken;

class ChatService implements IChatService
{
    public function __construct(
        private readonly IChatRepository $chatRepository,
        private readonly ITokenManager $tokenManager,
        private readonly INotifierManager $notifier
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
        $chat = $this->chatRepository->create($createChatDto);

        foreach ($chat->members as $member) {
            if($member->id !== $chat->creator->id) {
                $this->notifier->sendNotification($member->id, $chat);
            }
        }

        return $chat;
    }

    /**
     * @param int $chatId
     * @return ChatDto
     * @throws Forbidden
     * @throws InvalidToken
     */
    public function getChat(int $chatId): ChatDto
    {
        return $this->chatRepository->getChat($chatId, $this->tokenManager->getAuthUser()->id);
    }
}