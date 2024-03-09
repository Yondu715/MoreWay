<?php

namespace Src\App\Dto\User;

use App\Http\Requests\User\ChangeUserDataRequest;

class ChangeUserDataDto
{
    public readonly int $userId;
    public readonly ?string $name;

    public static function fromRequest(ChangeUserDataRequest $changeUserDataRequest): self
    {
        $dto = new self();

        $dto->userId = (int) $changeUserDataRequest->route('userId');
        $dto->name = $changeUserDataRequest->name;
        return $dto;
    }
}
