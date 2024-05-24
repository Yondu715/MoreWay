<?php

namespace App\Application\Services\Chat\Message;

use App\Application\Contracts\In\Services\Chat\Message\IMessageService;
use App\Application\Contracts\Out\Managers\Notifier\INotifierManager;
use App\Application\Contracts\Out\Managers\Token\ITokenManager;
use App\Application\Contracts\Out\Repositories\Chat\IChatRepository;
use App\Application\Contracts\Out\Repositories\Chat\Message\IMessageRepository;
use App\Application\DTO\Collection\CursorDto;
use App\Application\DTO\In\Chat\Message\AddMessageDto;
use App\Application\DTO\In\Chat\Message\GetMessagesDto;
use App\Application\DTO\Out\Chat\Message\MessageDto;
use App\Application\Exceptions\Chat\Message\FailedToGetMessages;
use App\Infrastructure\Exceptions\Forbidden;
use App\Infrastructure\Exceptions\InvalidToken;

class MessageService implements IMessageService
{
    public function __construct(
        private readonly IChatRepository $chatRepository,
        private readonly IMessageRepository $messageRepository,
        private readonly ITokenManager $tokenManager,
        private readonly INotifierManager $notifier
    ) {}

    /**
     * @param AddMessageDto $addMessageDto
     * @return MessageDto
     * @throws FailedToGetMessages
     * @throws Forbidden
     */
    public function createMessage(AddMessageDto $addMessageDto): MessageDto
    {
        $message = $this->messageRepository->create($addMessageDto);

        foreach ($this->chatRepository->getChat($addMessageDto->chatId, $addMessageDto->senderId)->members as $member) {
            if($member->id !== $addMessageDto->senderId) {
                $this->notifier->sendNotification($member->id, $message);
            }
        }

        return $message;
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