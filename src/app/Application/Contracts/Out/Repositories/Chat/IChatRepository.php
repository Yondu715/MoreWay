<?php

namespace App\Application\Contracts\Out\Repositories\Chat;

use App\Application\DTO\In\Chat\CreateChatDto;
use App\Application\DTO\Out\Chat\ChatDto;
use App\Application\Exceptions\Chat\FailedToCreateChat;

interface IChatRepository
{
    /**
     * @param CreateChatDto $createChatDto
     * @return ChatDto
     * @throws FailedToCreateChat
     */
    public function create(CreateChatDto $createChatDto): ChatDto;
}
