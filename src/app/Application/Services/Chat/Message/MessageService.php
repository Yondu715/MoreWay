<?php

namespace App\Application\Services\Chat\Message;

use App\Application\Contracts\In\Services\Chat\Message\IMessageService;
use App\Application\Contracts\Out\Repositories\Chat\Message\IMessageRepository;
use App\Application\DTO\In\Chat\Message\AddMessageDto;
use App\Application\DTO\Out\Chat\Message\MessageDto;
use App\Application\Exceptions\Chat\Message\FailedToCreateMessage;

class MessageService implements IMessageService
{
    public function __construct(
        private readonly IMessageRepository $messageRepository
    ) {}

    /**
     * @param AddMessageDto $addMessageDto
     * @return MessageDto
     * @throws FailedToCreateMessage
     */
    public function createMessage(AddMessageDto $addMessageDto): MessageDto
    {
        return $this->messageRepository->create($addMessageDto);
    }
}
