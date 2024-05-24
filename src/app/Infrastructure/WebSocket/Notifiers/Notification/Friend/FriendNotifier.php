<?php

namespace App\Infrastructure\WebSocket\Notifiers\Notification\Friend;

use App\Application\Contracts\Out\Managers\Notifier\INotifierManager;
use App\Infrastructure\Broker\RabbitMqPublisher;
use App\Infrastructure\Http\Resources\Friend\FriendshipRequestResource;
use App\Infrastructure\WebSocket\Notifiers\Notification\BaseNotifier;

class FriendNotifier extends BaseNotifier implements INotifierManager
{
    public function __construct(
        RabbitMqPublisher $publisher
    ) {
        parent::__construct($publisher, FriendshipRequestResource::class, "friendship");
    }
}
