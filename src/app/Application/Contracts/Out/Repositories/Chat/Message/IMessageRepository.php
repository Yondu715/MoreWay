<?php

namespace App\Application\Contracts\Out\Repositories\Chat\Message;

use App\Application\DTO\Collection\CursorDto;
use App\Application\DTO\In\Chat\Message\AddMessageDto;
use App\Application\DTO\In\Chat\Message\GetMessagesDto;
use App\Application\DTO\Out\Chat\Message\MessageDto;

interface IMessageRepository
{
    /**
     * @param AddMessageDto $addMessageDto
     * @return MessageDto
     */
    public function create(AddMessageDto $addMessageDto): MessageDto;

    /**
     * @param GetMessagesDto $getMessagesDto
     * @return CursorDto
     */
    public function getMessages(GetMessagesDto $getMessagesDto): CursorDto;
}
