<?php

namespace App\Infrastructure\WebSocket\Notifiers\Notification;

use App\Infrastructure\Broker\RabbitMqPublisher;
use Illuminate\Http\Resources\Json\JsonResource;

class BaseNotifier
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
        /** @var JsonResource $resource  */
        $resource = $this->resource;

        $message = [
            'to' => $userId,
            'type' => $this->type,
            'notification' => $resource::make($notification)
        ];
        $this->publisher->publish(
            routingKey: $this->queueName,
            body: json_encode($message)
        );
    }
}
