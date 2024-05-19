<?php

namespace App\Infrastructure\Database\Repositories\Chat\Message;

use App\Application\Contracts\Out\Repositories\Chat\Message\IMessageRepository;
use App\Application\DTO\In\Chat\Message\AddMessageDto;
use App\Application\DTO\Out\Chat\Message\MessageDto;
use App\Application\Exceptions\Chat\Message\FailedToCreateMessage;
use App\Infrastructure\Database\Models\Chat;
use App\Infrastructure\Database\Models\ChatMessage;
use App\Utils\Mappers\Out\Chat\Message\MessageDtoMapper;
use Illuminate\Database\Eloquent\Model;
use Exception;
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
     * @throws FailedToCreateMessage
     */
    public function create(AddMessageDto $addMessageDto): MessageDto
    {
        try {

            $chat = Chat::query()->where('id', $addMessageDto->chatId)
                ->whereHas('members', function ($query) use ($addMessageDto) {
                    $query->where('user_id', $addMessageDto->senderId);
                })->get();

            if(!count($chat)) {
                throw new Exception();
            }

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
}
