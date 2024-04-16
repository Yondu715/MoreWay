<?php

namespace App\Infrastructure\Database\Models\Infrastructure\Database\Models\Infrastructure\WebSocket\Controllers\Friend;

use App\Infrastructure\Database\Models\Infrastructure\Database\Models\Application\Contracts\Out\Managers\Notifier\INotifierManager;

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
