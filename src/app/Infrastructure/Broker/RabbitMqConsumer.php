<?php

namespace App\Infrastructure\Broker;

use Bunny\Async\Client;
use Bunny\Channel;
use React\EventLoop\Loop;

class RabbitMqConsumer
{
    private Client $client;

    public function __construct()
    {
        $loop = Loop::get();
        $this->client = new Client($loop, [
            'host' => config('queue.connections.rabbitmq.host'),
            'port' => config('queue.connections.rabbitmq.port'),
            'user' => config('queue.connections.rabbitmq.username'),
            'password' => config('queue.connections.rabbitmq.password'),
            'vhost' => config('queue.connections.rabbitmq.vhost')
        ]);
    }

    /**
     * @param string $routingKey
     * @param callable $callback
     * @return void
     */
    public function consume(string $routingKey, callable $callback): void
    {
        $this->client->connect()->then(
            fn (Client $client) => $client->channel()
        )->then(
            fn (Channel $channel) => $channel->qos()
                ->then(fn () => $channel)
        )->then(
            fn (Channel $channel) => $channel->queueDeclare($routingKey, false, true)
                ->then(fn () => $channel)
        )->then(
            fn (Channel $channel) => $channel->consume($callback, $routingKey)
        );
    }
}
