<?php

namespace App\Infrastructure\WebSocket\Notifiers\Notification\Chat;

use App\Application\Contracts\Out\Managers\Notifier\Chat\IChatNotifierManager;
use App\Infrastructure\Broker\RabbitMqPublisher;
use App\Infrastructure\Http\Resources\Chat\ChatResource;
use App\Infrastructure\WebSocket\Notifiers\Notification\BaseNotifier;

class ChatNotifier extends BaseNotifier implements IChatNotifierManager
{
    public function __construct(
        RabbitMqPublisher $publisher
    ) {
        parent::__construct($publisher, ChatResource::class, "chats");
    }
}
