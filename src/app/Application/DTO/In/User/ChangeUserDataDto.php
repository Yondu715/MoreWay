<?php

namespace App\Application\DTO\In\User;

use App\Infrastructure\Http\Requests\User\ChangeUserDataRequest;
use App\Infrastructure\Database\Models\Infrastructure\Database\Models\Lib\HashId\HashManager;

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
            userId: $changeUserDataRequest->route('userId'),
            name: $changeUserDataRequest->name
        );
    }
}
