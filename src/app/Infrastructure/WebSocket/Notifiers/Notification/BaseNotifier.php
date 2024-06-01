<?php

namespace App\Infrastructure\WebSocket\Notifiers\Notification;

use Illuminate\Support\Collection;
use App\Infrastructure\Broker\RabbitMqPublisher;

abstract class BaseNotifier
{
    private string $queueName = 'notification';
    private readonly RabbitMqPublisher $publisher;
    private string $resource;
    private string $type;

    public function __construct(
        RabbitMqPublisher $publisher,
        string $resource,
        string $type,
    ) {
        $this->type = $type;
        $this->publisher = $publisher;
        $this->resource = $resource;
    }

    /**
     * @param int $userId
     * @param mixed $notification
     * @return void
     */
    public function sendNotification(int $userId, mixed $notification): void
    {
        $json = $notification instanceof Collection ? $this->resource::collection($notification) : $this->resource::make($notification);

        $message = [
            'to' => $userId,
            'type' => $this->type,
            'notification' => $json
        ];
        $this->publisher->publish(
            routingKey: $this->queueName,
            body: json_encode($message)
        );
    }
}
