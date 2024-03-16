<?php

namespace App\DTO\In\User;

use App\Http\Requests\User\ChangeUserDataRequest;
use App\Lib\HashId\HashManager;

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
            userId: HashManager::decrypt($changeUserDataRequest->route('userId')),
            name: $changeUserDataRequest->name
        );
    }
}
