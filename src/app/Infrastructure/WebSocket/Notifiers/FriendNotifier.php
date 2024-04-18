<?php

namespace App\Infrastructure\WebSocket\Notifiers;

use App\Application\Contracts\Out\Managers\Notifier\INotifierManager;
use App\Infrastructure\WebSocket\Controllers\Friend\FriendWebSocketController;

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
