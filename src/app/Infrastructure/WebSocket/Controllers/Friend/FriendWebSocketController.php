<?php

namespace App\Infrastructure\WebSocket\Controllers\Friend;

use App\Application\Contracts\Out\Managers\Token\ITokenManager;
use App\Infrastructure\WebSocket\Controllers\NotifierWebSocket;

class FriendWebSocketController extends NotifierWebSocket
{

    public function __construct(ITokenManager $tokenManager)
    {
        parent::__construct($tokenManager);
    }
}
