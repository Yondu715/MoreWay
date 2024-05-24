<?php

namespace App\Application\Contracts\Out\Managers\Notifier\Friend;

interface IFriendNotifierManager
{
    /**
     * @param int $userId
     * @param mixed $notification
     * @return void
     */
    public function sendNotification(int $userId, mixed $notification): void;
}
