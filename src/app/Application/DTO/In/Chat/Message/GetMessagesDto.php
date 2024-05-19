<?php

namespace App\Application\DTO\In\Chat\Message;

class GetMessagesDto
{
    public readonly int $chatId;
    public readonly ?string $cursor;
    public readonly ?int $limit;

    public function __construct(
        int $chatId,
        ?string $cursor,
        ?int $limit
    ) {
        $this->chatId = $chatId;
        $this->cursor = $cursor;
        $this->limit = $limit;
    }
}
