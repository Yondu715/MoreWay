<?php

namespace App\Application\Contracts\In\Services\Chat\Message;

use App\Application\DTO\In\Chat\Message\AddMessageDto;
use App\Application\DTO\Out\Chat\Message\MessageDto;
use App\Application\Exceptions\Chat\Message\FailedToCreateMessage;

interface IMessageService
{
    /**
     * @param AddMessageDto $addMessageDto
     * @return MessageDto
     * @throws FailedToCreateMessage
     */
    public function createMessage(AddMessageDto $addMessageDto): MessageDto;
}
