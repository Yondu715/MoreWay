<?php

namespace App\Infrastructure\WebSocket\Notifiers\Notification\Chat\Message;

use App\Application\Contracts\Out\Managers\Notifier\INotifierManager;
use App\Infrastructure\Broker\RabbitMqPublisher;
use App\Infrastructure\Http\Resources\Chat\Message\MessageResource;
use App\Infrastructure\WebSocket\Notifiers\Notification\BaseNotifier;

class MessageNotifier extends BaseNotifier implements INotifierManager
{
    public function __construct(
        RabbitMqPublisher $publisher
    ) {
        parent::__construct($publisher, MessageResource::class, "chats/message");
    }
}
