<?php

namespace App\Application\DTO\In\Friend;

use App\Infrastructure\Http\Requests\Friend\AcceptFriendRequest;

class AcceptFriendDto
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
