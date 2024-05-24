<?php

namespace App\Infrastructure\WebSocket\Controllers\Friend;

use App\Application\Contracts\Out\Managers\Token\ITokenManager;
use App\Infrastructure\Broker\RabbitMqConsumer;
use App\Infrastructure\WebSocket\Broker\BrokerWebSocket;

class FriendWebSocketController extends BrokerWebSocket
{
    public function __construct(
        ITokenManager $tokenManager,
        RabbitMqConsumer $rabbitMqConsumer
    ) {
        parent::__construct($tokenManager, $rabbitMqConsumer, "notification:friends");
    }
}
