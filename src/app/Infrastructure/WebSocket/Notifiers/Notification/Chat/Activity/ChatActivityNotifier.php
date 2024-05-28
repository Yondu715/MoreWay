<?php

namespace App\Infrastructure\WebSocket\Notifiers\Notification\Chat\Activity;

use App\Application\Contracts\Out\Managers\Notifier\INotifierManager;
use App\Infrastructure\Broker\RabbitMqPublisher;
use App\Infrastructure\Http\Resources\Route\RouteResource;
use App\Infrastructure\WebSocket\Notifiers\Notification\BaseNotifier;

class ChatActivityNotifier extends BaseNotifier implements INotifierManager
{
    public function __construct(
        RabbitMqPublisher $publisher
    ) {
        parent::__construct($publisher, RouteResource::class, "chats/activity");
    }
}
