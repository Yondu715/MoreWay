<?php

namespace App\Infrastructure\WebSocket\Controllers\Friend;

use App\Application\Contracts\Out\Managers\Notifier\INotifierManager;

class FriendNotifier implements INotifierManager
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
