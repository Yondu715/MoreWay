<?php

namespace App\Infrastructure\Database\Repositories\Chat\Message;

use Throwable;
use Illuminate\Database\Eloquent\Model;
use App\Application\DTO\Collection\CursorDto;
use App\Infrastructure\Database\Models\ChatMessage;
use App\Application\DTO\Out\Chat\Message\MessageDto;
use App\Application\DTO\In\Chat\Message\AddMessageDto;
use App\Application\DTO\In\Chat\Message\GetMessagesDto;
use App\Utils\Mappers\Out\Chat\Message\MessageDtoMapper;
use App\Application\Exceptions\Chat\Message\FailedToCreateMessage;
use App\Application\Contracts\Out\Repositories\Chat\Message\IMessageRepository;

class MessageRepository implements IMessageRepository
{
    private readonly Model $model;

    public function __construct(
        ChatMessage $message
    ) {
        $this->model = $message;
    }

    /**
     * @param AddMessageDto $addMessageDto
     * @return MessageDto
     * @throws FailedToCreateMessage
     */
    public function create(AddMessageDto $addMessageDto): MessageDto
    {
        try {
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
     * @return CursorDto
     */
    public function getMessages(GetMessagesDto $getMessagesDto): CursorDto
    {
        $messages = $this->model->query()->where('chat_id', $getMessagesDto->chatId)
            ->cursorPaginate(perPage: $getMessagesDto->limit, cursor: $getMessagesDto->cursor);
        return MessageDtoMapper::fromPaginator($messages);
    }
}
