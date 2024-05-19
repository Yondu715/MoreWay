<?php

namespace App\Application\DTO\In\Chat\Member;

class AddMembersDto
{
    public readonly int $chatId;
    public readonly array $members;

    public function __construct(
        int $chatId,
        array $members
    ) {
        $this->chatId = $chatId;
        $this->members = $members;
    }
}
