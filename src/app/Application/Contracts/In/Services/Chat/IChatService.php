<?php

namespace App\Application\Contracts\In\Services\Chat;

use App\Application\DTO\In\Chat\CreateChatDto;
use App\Application\DTO\Out\Chat\ChatDto;
use App\Application\Exceptions\Chat\FailedToCreateChat;

interface IChatService
{
    /**
     * @param CreateChatDto $createChatDto
     * @return ChatDto
     * @throws FailedToCreateChat
     */
    public function createChat(CreateChatDto $createChatDto): ChatDto;
}
