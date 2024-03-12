<?php

namespace App\DTO\Friend;

use App\Http\Requests\Friend\AcceptFriendRequest;

class AcceptFriendRequestDto
{
    public readonly int $requestId;

    public static function fromRequest(AcceptFriendRequest $acceptFriendRequest): self
    {
        $dto = new self();

        $dto->requestId = $acceptFriendRequest->requestId;
        return $dto;
    }
}
