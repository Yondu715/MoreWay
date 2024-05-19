<?php

namespace App\Application\Services\Chat\Message;

use App\Application\Contracts\In\Services\Chat\Message\IMessageService;
use App\Application\Contracts\Out\Managers\Token\ITokenManager;
use App\Application\Contracts\Out\Repositories\Chat\Message\IMessageRepository;
use App\Application\DTO\Collection\CursorDto;
use App\Application\DTO\In\Chat\Message\AddMessageDto;
use App\Application\DTO\In\Chat\Message\GetMessagesDto;
use App\Application\DTO\Out\Chat\Message\MessageDto;
use App\Application\Exceptions\Chat\Message\FailedToGetMessages;
use App\Infrastructure\Exceptions\InvalidToken;

class MessageService implements IMessageService
{
    public function __construct(
        private readonly IMessageRepository $messageRepository,
        private readonly ITokenManager $tokenManager
    ) {}

    /**
     * @param AddMessageDto $addMessageDto
     * @return MessageDto
     * @throws FailedToGetMessages
     */
    public function createMessage(AddMessageDto $addMessageDto): MessageDto
    {
        return $this->messageRepository->create($addMessageDto);
    }

    /**
     * @param GetMessagesDto $getMessagesDto
     * @return CursorDto
     * @throws FailedToGetMessages
     * @throws InvalidToken
     */
    public function getMessages(GetMessagesDto $getMessagesDto): CursorDto
    {
        return $this->messageRepository->getMessages($getMessagesDto, $this->tokenManager->getAuthUser()->id);
    }
}
