<?php

namespace App\Application\Contracts\Out\Notification;

interface INotifier
{
    public function sendNotification(int $userId, mixed $notification);
}