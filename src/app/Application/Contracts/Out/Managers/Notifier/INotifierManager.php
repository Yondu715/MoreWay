<?php

namespace App\Infrastructure\Database\Models\Infrastructure\Database\Models\Application\Contracts\Out\Managers\Notifier;

interface INotifierManager
{
    /**
     * @param int $userId
     * @param mixed $notification
     * @return mixed
     */
    public function sendNotification(int $userId, mixed $notification);
}
