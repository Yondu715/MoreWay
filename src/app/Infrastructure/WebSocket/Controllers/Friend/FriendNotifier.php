<?php

namespace App\Infrastructure\Websocket\Controllers\Friend;

use App\Application\Contracts\Out\Notification\INotifier;
use App\Infrastructure\WebSocket\Controllers\Friend\FriendWebSocketController;

class FriendNotifier implements INotifier
{
    /**
     * @param int $userId
     * @param mixed $notification
     * @return void
     */
    public function sendNotification(int $userId, mixed $notification): void
    {
        FriendWebSocketController::sendNotification($userId, $notification);
    }
}
