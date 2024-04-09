<?php

namespace App\Infrastructure\Websocket\Controllers\Friend;

use App\Application\Contracts\Out\Notification\INotifier;
use App\Infrastructure\WebSocket\Controllers\Friend\FriendWebSocketController;

class FriendNotifier implements INotifier
{
    public function sendNotification(int $userId, mixed $notification)
    {
        FriendWebSocketController::sendNotification($userId, $notification);
    }
}
