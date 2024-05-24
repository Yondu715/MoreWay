<?php

namespace App\Application\Contracts\In\Services\Chat;

use App\Application\DTO\Collection\CursorDto;
use App\Application\DTO\In\Chat\CreateChatDto;
use App\Application\DTO\In\Chat\GetUserChatsDto;
use App\Application\DTO\Out\Chat\ChatDto;
use App\Application\Exceptions\Chat\FailedToCreateChat;
use App\Infrastructure\Exceptions\Forbidden;
use App\Infrastructure\Exceptions\InvalidToken;

interface IChatService
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
    public function createChat(CreateChatDto $createChatDto): ChatDto;

    /**
     * @param int $chatId
     * @return ChatDto
     * @throws Forbidden
     * @throws InvalidToken
     */
    public function getChat(int $chatId): ChatDto;
}
