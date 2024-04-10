<?php

namespace App\Application\Contracts\Out\Managers;

interface INotifierManager
{
    public function sendNotification(int $userId, mixed $notification);
}