<?php

namespace App\Application\Contracts\In\Services\Chat\Message;

use App\Application\DTO\Collection\CursorDto;
use App\Application\DTO\In\Chat\Message\AddMessageDto;
use App\Application\DTO\In\Chat\Message\GetMessagesDto;
use App\Application\DTO\Out\Chat\Message\MessageDto;
use App\Application\Exceptions\Chat\Message\FailedToGetMessages;
use App\Infrastructure\Exceptions\InvalidToken;

interface IMessageService
{
    /**
     * @param AddMessageDto $addMessageDto
     * @return MessageDto
     * @throws FailedToGetMessages
     */
    public function createMessage(AddMessageDto $addMessageDto): MessageDto;

    /**
     * @param GetMessagesDto $getMessagesDto
     * @return CursorDto
     * @throws FailedToGetMessages
     * @throws InvalidToken
     */
    public function getMessages(GetMessagesDto $getMessagesDto): CursorDto;
}
