<?php

namespace App\Infrastructure\WebSocket\Notifiers\Notification\Chat\Vote\Activity\Point;

use App\Application\Contracts\Out\Managers\Notifier\INotifierManager;
use App\Infrastructure\Broker\RabbitMqPublisher;
use App\Infrastructure\Http\Resources\Chat\Vote\VoteResource;

use App\Infrastructure\WebSocket\Notifiers\Notification\BaseNotifier;

class ActivityPointNotifier extends BaseNotifier implements INotifierManager
{
    public function __construct(
        RabbitMqPublisher $publisher
    ) {
        parent::__construct($publisher, VoteResource::class, "chats/votes/routePoint");
    }
}
