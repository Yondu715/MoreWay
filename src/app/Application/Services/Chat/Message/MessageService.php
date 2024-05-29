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
use App\Application\Exceptions\Chat\ChatNotFound;
use App\Application\Exceptions\Chat\Members\UserIsNotChatMember;
use App\Application\Exceptions\Chat\Message\FailedToGetMessages;

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
     * @throws ChatNotFound
     * @throws FailedToGetMessages
     * @throws UserIsNotChatMember
     */
    public function createMessage(AddMessageDto $addMessageDto): MessageDto
    {
        $chat = $this->chatRepository->findById($addMessageDto->chatId);
        $member = $chat->members->first(fn ($value) => $value->id === $this->tokenManager->getAuthUser()->user->id);

        if (!$member) {
            throw new UserIsNotChatMember();
        }

        $message = $this->messageRepository->create($addMessageDto);

        foreach ($chat->members as $member) {
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
     * @throws UserIsNotChatMember
     * @throws ChatNotFound
     */
    public function getMessages(GetMessagesDto $getMessagesDto): CursorDto
    {
        $chat = $this->chatRepository->findById($getMessagesDto->chatId);
        $member = $chat->members->first(fn ($value) => $value->id === $this->tokenManager->getAuthUser()->user->id);

        if (!$member) {
            throw new UserIsNotChatMember();
        }

        return $this->messageRepository->getMessages($getMessagesDto);
    }
}
