<?php

namespace App\Application\DTO\In\Friend;

class AcceptFriendDto
{
    public readonly int $requestId;

    public function __construct(
        int $requestId
    ) {
        $this->requestId = $requestId;
    }

}
