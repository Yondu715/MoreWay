<?php

namespace App\DTO\User;

use App\Http\Requests\User\ChangeUserDataRequest;

class ChangeUserDataDto
{
    public readonly int $userId;
    public readonly ?string $name;

    public function __construct(
        int $userId,
        ?string $name
    ) {
        $this->userId = $userId;
        $this->name = $name;
    }

    public static function fromRequest(ChangeUserDataRequest $changeUserDataRequest): self
    {
        return new self(
            userId: (int) $changeUserDataRequest->route('userId'),
            name: $changeUserDataRequest->name
        );
    }
}
