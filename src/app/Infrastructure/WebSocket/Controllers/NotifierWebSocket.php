<?php

namespace App\Infrastructure\WebSocket\Controllers;

use App\Application\Contracts\Out\Managers\Token\ITokenManager;
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
    protected static array $clients = [];

    public function __construct(
        protected readonly ITokenManager $tokenManager
    ) {
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

        self::$clients[$user->id] = $conn;
        echo "Новое соединение для пользователя с id={$user->id}\n";
        $conn->send('Вы успешно подключились');
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
        $userId = array_search($conn, self::$clients, true);
        if (!$userId) {
            echo "Соединение закрыто, но клиент не был найден в списке.\n";
            return;
        }

        unset(self::$clients[$userId]);
        echo "Соединение закрыто! {$userId}\n";
    }

    /**
     * @param ConnectionInterface $conn
     * @param Exception $e
     * @return void
     */
    public function onError(ConnectionInterface $conn, Exception $e): void
    {
        $userId = array_search($conn, self::$clients, true);
        unset(self::$clients[$userId]);
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

    /**
     * @param int $userId
     * @param mixed $notification
     * @return void
     */
    public static function sendNotification(int $userId, mixed $notification): void
    {
        $isUserExist = isset(self::$clients[$userId]);
        if (!$isUserExist) {
            echo "Клиент с ID $userId не найден.\n";
            return;
        }
        self::$clients[$userId]->send(json_encode($notification));
    }
}
