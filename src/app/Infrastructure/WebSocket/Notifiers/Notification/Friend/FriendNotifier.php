<?php

namespace App\Infrastructure\WebSocket\Notifiers\Notification\Friend;

use App\Application\Contracts\Out\Managers\Notifier\INotifierManager;
use App\Infrastructure\Broker\RabbitMqPublisher;
use App\Infrastructure\Http\Resources\Friend\FriendshipResource;
use App\Infrastructure\WebSocket\Notifiers\Notification\BaseNotifier;

class FriendNotifier extends BaseNotifier implements INotifierManager
{
    public function __construct(
        RabbitMqPublisher $publisher
    ) {
        parent::__construct($publisher, FriendshipResource::class, "friendship");
    }
}
