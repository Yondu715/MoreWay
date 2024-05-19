<?php

namespace App\Application\Contracts\Out\Repositories\Chat;

use App\Application\DTO\Collection\CursorDto;
use App\Application\DTO\In\Chat\CreateChatDto;
use App\Application\DTO\In\Chat\GetUserChatsDto;
use App\Application\DTO\Out\Chat\ChatDto;
use App\Application\Exceptions\Chat\FailedToCreateChat;
use App\Infrastructure\Exceptions\Forbidden;

interface IChatRepository
{
    /**
     * @param GetUserChatsDto $getUserChatsDto
     * @return CursorDto
     */
    public function getUserChats(GetUserChatsDto $getUserChatsDto): CursorDto;

    /**
     * @param CreateChatDto $createChatDto
     * @return ChatDto
     * @throws FailedToCreateChat
     */
    public function create(CreateChatDto $createChatDto): ChatDto;

    /**
     * @param int $chatId
     * @param int $userId
     * @return ChatDto
     * @throws Forbidden
     */
    public function getChat(int $chatId, int $userId): ChatDto;
}
