<?php

namespace App\DTO\Friend;

use App\Http\Requests\Friend\AcceptFriendRequest;

class AcceptFriendRequestDto
{
    public readonly int $requestId;

    public function __construct(
        int $requestId
    ) {
        $this->requestId = $requestId;
    }

    public static function fromRequest(AcceptFriendRequest $acceptFriendRequest): self
    {
        return new self(
            requestId: $acceptFriendRequest->requestId
        );
    }
}
