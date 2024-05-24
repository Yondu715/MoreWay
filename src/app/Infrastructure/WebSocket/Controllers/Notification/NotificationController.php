<?php

namespace App\Infrastructure\WebSocket\Controllers\Notification;

use App\Application\Contracts\Out\Managers\Token\ITokenManager;
use App\Infrastructure\Broker\RabbitMqConsumer;
use App\Infrastructure\WebSocket\Controllers\NotifierWebSocket;
use Bunny\Channel;
use Bunny\Message;
use Psr\Log\LoggerInterface;
use Throwable;

class NotificationController extends NotifierWebSocket
{
    private string $queueName = 'notification';
    private RabbitMqConsumer $consumer;

    public function __construct(
        ITokenManager $tokenManager,
        RabbitMqConsumer $rabbitMqConsumer,
    ) {
        parent::__construct($tokenManager);
        $this->consumer = $rabbitMqConsumer;
        $this->consumer->consume($this->queueName, function (Message $message, Channel $channel) {
            try {
                $msg = json_decode($message->content, true);
                $this->sendNotification($msg['to'], json_encode([
                    'data' => $msg['notification'],
                    'type' => $msg['type'],
                ]));
                $channel->ack($message);
            } catch (Throwable $th) {
                $logger = app(LoggerInterface::class);
                $logger->info($th->getMessage());
                $channel->nack($message);
            }
        });
    }

    /**
     * @param int $userId
     * @param string $notification
     * @return void
     */
    public function sendNotification(int $userId, string $notification): void
    {
        if (!isset($this->clients[$userId])) {
            return;
        }
        $this->clients[$userId]->send($notification);
    }
}
