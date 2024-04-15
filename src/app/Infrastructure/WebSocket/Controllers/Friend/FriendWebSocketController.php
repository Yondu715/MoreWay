<?php

namespace App\Infrastructure\WebSocket\Controllers\Friend;

use App\Application\Contracts\Out\Managers\Token\ITokenManager;
use Exception;
use Psr\Http\Message\RequestInterface;
use Ratchet\ConnectionInterface;
use Ratchet\RFC6455\Messaging\MessageInterface;
use Ratchet\WebSocket\MessageComponentInterface;

class FriendWebSocketController implements MessageComponentInterface
{

    /**
     * @var array<int, ConnectionInterface>
     */
    private static array $clients = [];

    public function __construct(
        private readonly ITokenManager $tokenManager
    ) {
    }

    public function onOpen(ConnectionInterface $conn)
    {
        $params = $this->parseQuery($conn->httpRequest);
        $token = $params['token'] ?? null;

        if (!$token) {
            $conn->send('Необходимо добавить query параметр token');
            $conn->close();
            return;
        }

        $user = $this->tokenManager->parseToken($token);

        self::$clients[$user->id] = $conn;
        echo "Новое соединение для пользователя с id={$user->id}\n";
        $conn->send('Вы успешно подключились');
    }

    public function onMessage(ConnectionInterface $conn, MessageInterface $msg)
    {
    }

    public function onClose(ConnectionInterface $conn)
    {
        $userId = array_search($conn, self::$clients, true);
        if (!$userId) {
            echo "Соединение закрыто, но клиент не был найден в списке.\n";
            return;
        }

        unset(self::$clients[$userId]);
        echo "Соединение закрыто! {$userId}\n";
    }

    public function onError(ConnectionInterface $conn, Exception $e)
    {
        $conn->send($e->getMessage());
        $conn->close();
        echo "Ошибка! " . $e->getMessage() . "\n";
    }

    private function parseQuery(RequestInterface $request)
    {
        $params = [];
        $queryParams = $request->getUri()->getQuery();
        parse_str($queryParams, $params);
        return $params;
    }

    public static function sendNotification(int $userId, mixed $notification)
    {
        $isUserExist = isset(self::$clients[$userId]);
        if (!$isUserExist) {
            echo "Клиент с ID $userId не найден.\n";
            return;
        }
        self::$clients[$userId]->send(json_encode($notification));
    }
}
