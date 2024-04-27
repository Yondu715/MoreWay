<?php

namespace App\Infrastructure\WebSocket\Controllers;

use App\Application\Contracts\Out\Managers\Token\ITokenManager;
use Bunny\Async\Client;
use Bunny\Channel;
use Bunny\Message;
use Exception;
use Psr\Http\Message\RequestInterface;
use Psr\Log\LoggerInterface;
use Ratchet\ConnectionInterface;
use Ratchet\RFC6455\Messaging\MessageInterface;
use Ratchet\WebSocket\MessageComponentInterface;
use React\EventLoop\Loop;

abstract class NotifierWebSocket implements MessageComponentInterface
{

    protected array $clients = [];
    private Client $connection;
    private string $queueName = 'ws';

    public function __construct(
        protected readonly ITokenManager $tokenManager
    ) {
        $loop = Loop::get();
        $this->connection = new Client($loop, [
            'host' => config('queue.connections.rabbitmq.host'),
            'port' => config('queue.connections.rabbitmq.port'),
            'user' => config('queue.connections.rabbitmq.username'),
            'password' => config('queue.connections.rabbitmq.password'),
            'vhost' => config('queue.connections.rabbitmq.vhost')
        ]);
        $logger = app(LoggerInterface::class);
        $this->connection->connect()->then(function (Client $client) {
            return $client->channel();
        })->then(function (Channel $channel) {
            return $channel->qos(0, 5)->then(function () use ($channel) {
                return $channel;
            });
        })->then(function (Channel $channel) {
            $channel->consume(function (Message $message, Channel $channel, Client $client) {
                $logger = app(LoggerInterface::class);
                $logger->info('success');
            }, $this->queueName);
        });
        $logger->info('setup done');
    }

    /**
     * @param ConnectionInterface $conn
     * @return void
     */
    public function onOpen(ConnectionInterface $conn): void
    {
        $params = $this->parseQuery($conn->httpRequest);
        $token = $params['token'] ?? null;
        if (!$token) {
            $conn->send('Необходимо добавить query параметр token');
            $conn->close();
            return;
        }

        $user = $this->tokenManager->parseToken($token);

        if (!$user) {
            $conn->send('Некорректный токен');
            $conn->close();
            return;
        }

        $this->clients[$user->id] = $conn;
    }

    /**
     * @param ConnectionInterface $conn
     * @param MessageInterface $msg
     * @return void
     */
    public function onMessage(ConnectionInterface $conn, MessageInterface $msg): void
    {
    }

    /**
     * @param ConnectionInterface $conn
     * @return void
     */
    public function onClose(ConnectionInterface $conn): void
    {
        $userId = array_search($conn, $this->clients, true);
        if (!$userId) {
            echo "Соединение закрыто, но клиент не был найден в списке.\n";
            return;
        }

        unset($this->clients[$userId]);
        echo "Соединение закрыто! {$userId}\n";
    }

    /**
     * @param ConnectionInterface $conn
     * @param Exception $e
     * @return void
     */
    public function onError(ConnectionInterface $conn, Exception $e): void
    {
        $userId = array_search($conn, $this->clients, true);
        unset($this->clients[$userId]);
        $conn->close();
        echo "Ошибка! " . $e->getMessage();
    }

    /**
     * @param RequestInterface $request
     * @return array<string, string>
     */
    private function parseQuery(RequestInterface $request): array
    {
        $params = [];
        $queryParams = $request->getUri()->getQuery();
        parse_str($queryParams, $params);
        return $params;
    }



    private function handleNotification(int $userId, string $msg): void
    {
        $this->clients[$userId]->send($msg);
    }
}
