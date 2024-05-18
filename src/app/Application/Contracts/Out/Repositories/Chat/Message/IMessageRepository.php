<?php

namespace App\Application\Contracts\Out\Repositories\Chat\Message;

use App\Application\DTO\In\Chat\Message\AddMessageDto;
use App\Application\DTO\Out\Chat\Message\MessageDto;
use App\Application\Exceptions\Chat\Message\FailedToCreateMessage;

interface IMessageRepository
{
    /**
     * @param AddMessageDto $addMessageDto
     * @return MessageDto
     * @throws FailedToCreateMessage
     */
    public function create(AddMessageDto $addMessageDto): MessageDto;
}
