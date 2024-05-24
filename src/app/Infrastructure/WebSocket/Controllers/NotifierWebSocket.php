<?php

namespace App\Infrastructure\WebSocket\Controllers;

use App\Application\Contracts\Out\Managers\Token\ITokenManager;
use App\Infrastructure\Exceptions\InvalidToken;
use Exception;
use Psr\Http\Message\RequestInterface;
use Ratchet\ConnectionInterface;
use Ratchet\RFC6455\Messaging\MessageInterface;
use Ratchet\WebSocket\MessageComponentInterface;

abstract class NotifierWebSocket implements MessageComponentInterface
{

    /**
     * @var array<int, ConnectionInterface>
     */
    protected array $clients = [];
    protected readonly ITokenManager $tokenManager;

    public function __construct(
        ITokenManager $tokenManager,
    ) {
        $this->tokenManager = $tokenManager;
    }

    /**
     * @param ConnectionInterface $conn
     * @return void
     * @throws InvalidToken
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
            return;
        }
        unset($this->clients[$userId]);
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
    }

    /**
     * @param RequestInterface $request
     * @return array<string, string>
     */
    private function parseQuery(RequestInterface $request): array
    {
        parse_str($request->getUri()->getQuery(), $params);
        return $params;
    }
}
