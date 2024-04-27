<?php

namespace App\Infrastructure\WebSocket\Notifiers;

use App\Application\Contracts\Out\Managers\Notifier\INotifierManager;
use Bunny\Channel;
use Bunny\Client;

class FriendNotifier implements INotifierManager
{

    private Client $connection;
    private Channel $channel;
    private string $queueName;


    public function __construct()
    {
        $this->connection = new Client([
            'host' => config('queue.connections.rabbitmq.host'),
            'port' => config('queue.connections.rabbitmq.port'),
            'user' => config('queue.connections.rabbitmq.username'),
            'password' => config('queue.connections.rabbitmq.password'),
            'vhost' => config('queue.connections.rabbitmq.vhost')
        ]);
        $this->channel = $this->connection->channel();
        $this->queueName = 'ws';
    }

    public function __destruct()
    {
        $this->channel->close();
        $this->connection->disconnect();
    }

    /**
     * @param int $userId
     * @param mixed $notification
     * @return void
     */
    public function sendNotification(int $userId, mixed $notification): void
    {
        $this->channel->publish(
            body: json_encode($notification),
            routingKey: $this->queueName
        );
    }
}
