<?php

namespace App\Infrastructure\Broker;

use Bunny\Client;
use Bunny\Channel;

class RabbitMqPublisher
{
    private Client $client;
    private Channel $channel;

    public function __construct()
    {
        $this->client = new Client([
            'host' => config('queue.connections.rabbitmq.host'),
            'port' => config('queue.connections.rabbitmq.port'),
            'vhost' => config('queue.connections.rabbitmq.vhost'),
            'user' => config('queue.connections.rabbitmq.username'),
            'password' => config('queue.connections.rabbitmq.password'),
        ]);
        $this->client->connect();
        $this->channel = $this->client->channel();
    }

    /**
     * @param string $routingKey
     * @param string $body
     * @return void
     */
    public function publish(string $routingKey, string $body): void
    {
        $this->channel->publish(
            body: $body,
            routingKey: $routingKey
        );
    }
}
