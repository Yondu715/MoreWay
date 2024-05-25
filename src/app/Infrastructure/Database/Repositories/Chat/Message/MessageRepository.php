<?php

namespace App\Infrastructure\Database\Repositories\Chat\Message;

use App\Application\Contracts\Out\Repositories\Chat\Message\IMessageRepository;
use App\Application\DTO\Collection\CursorDto;
use App\Application\DTO\In\Chat\Message\AddMessageDto;
use App\Application\DTO\In\Chat\Message\GetMessagesDto;
use App\Application\DTO\Out\Chat\Message\MessageDto;
use App\Application\Exceptions\Chat\Message\FailedToCreateMessage;
use App\Application\Exceptions\Chat\Message\FailedToGetMessages;
use App\Infrastructure\Database\Models\Chat;
use App\Infrastructure\Database\Models\ChatMessage;
use App\Utils\Mappers\Out\Chat\Message\MessageDtoMapper;
use Illuminate\Database\Eloquent\Model;
use Throwable;

class MessageRepository implements IMessageRepository
{
    private readonly Model $model;

    public function __construct(
        ChatMessage $message
    )
    {
        $this->model = $message;
    }

    /**
     * @param AddMessageDto $addMessageDto
     * @return MessageDto
     * @throws FailedToGetMessages
     */
    public function create(AddMessageDto $addMessageDto): MessageDto
    {
        try {
            Chat::query()->whereHas('members', function ($query) use ($addMessageDto) {
                $query->where('user_id', $addMessageDto->senderId);
            })->where('id', $addMessageDto->chatId)->firstOrFail();

            /** @var ChatMessage $message */
            $message = $this->model->query()->create([
                'text' => $addMessageDto->message,
                'sender_id' => $addMessageDto->senderId,
                'chat_id' => $addMessageDto->chatId,
            ]);

            return MessageDtoMapper::fromMessageModel($message);
        } catch (Throwable) {
            throw new FailedToCreateMessage();
        }
    }

    /**
     * @param GetMessagesDto $getMessagesDto
     * @param int $userId
     * @return CursorDto
     * @throws FailedToGetMessages
     */
    public function getMessages(GetMessagesDto $getMessagesDto, int $userId): CursorDto
    {
        try {
            Chat::query()->whereHas('members', function ($query) use ($userId) {
                $query->where('user_id', $userId);
            })->where('id', $getMessagesDto->chatId)->firstOrFail();

            $messages = $this->model->query()->where('chat_id', $getMessagesDto->chatId)
            ->cursorPaginate(perPage: $getMessagesDto->limit, cursor: $getMessagesDto->cursor);

            return MessageDtoMapper::fromPaginator($messages);
        } catch (Throwable) {
            throw new FailedToGetMessages();
        }
    }
}
