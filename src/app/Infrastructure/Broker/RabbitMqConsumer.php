<?php

namespace App\Infrastructure\Broker;

use Bunny\Async\Client;
use Bunny\Channel;
use Bunny\Message;
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
        $this->client->connect()->then(function (Client $client) {
            return $client->channel();
        })->then(function (Channel $channel) {
            return $channel->qos()->then(function () use ($channel) {
                return $channel;
            });
        })->then(function (Channel $channel) use ($routingKey, $callback) {
            $channel->consume($callback, $routingKey);
        });
    }
}
