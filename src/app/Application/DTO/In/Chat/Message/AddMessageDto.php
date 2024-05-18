<?php

namespace App\Application\DTO\In\Chat\Message;

class AddMessageDto
{
    public readonly int $chatId;
    public readonly int $senderId;
    public readonly string $message;

    public function __construct(
        int $chatId,
        int $senderId,
        string $message
    ) {
        $this->chatId = $chatId;
        $this->senderId = $senderId;
        $this->message = $message;
    }
}
