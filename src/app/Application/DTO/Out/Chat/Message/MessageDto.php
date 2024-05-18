<?php

namespace App\Application\DTO\Out\Chat\Message;

use App\Application\DTO\Out\Auth\UserDto;

class MessageDto
{
    public readonly int $id;
    public readonly string $message;
    public readonly string $createdAt;
    public readonly UserDto $sender;

    public function __construct(
        int        $id,
        string     $message,
        string     $createdAt,
        UserDto    $sender,
    ) {
        $this->id = $id;
        $this->message = $message;
        $this->createdAt = $createdAt;
        $this->sender = $sender;
    }
}
