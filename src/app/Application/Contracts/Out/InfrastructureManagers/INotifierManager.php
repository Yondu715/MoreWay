<?php

namespace App\Application\Contracts\Out\InfrastructureManagers;

interface INotifierManager
{
    public function sendNotification(int $userId, mixed $notification);
}
