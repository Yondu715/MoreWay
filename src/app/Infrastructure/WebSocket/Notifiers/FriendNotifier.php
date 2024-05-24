<?php

namespace App\Infrastructure\WebSocket\Notifiers;

use App\Application\Contracts\Out\Managers\Notifier\INotifierManager;
use App\Infrastructure\Broker\RabbitMqPublisher;

class FriendNotifier implements INotifierManager
{

    private string $queueName = 'notification:friends';
    private readonly RabbitMqPublisher $publisher;

    public function __construct(
        RabbitMqPublisher $publisher
    ) {
        $this->publisher = $publisher;
    }

    /**
     * @param int $userId
     * @param mixed $notification
     * @return void
     */
    public function sendNotification(int $userId, mixed $notification): void
    {
        $message = [
            'to' => $userId,
            'notification' => $notification
        ];
        $this->publisher->publish(
            routingKey: $this->queueName,
            body: json_encode($message)
        );
    }
}
