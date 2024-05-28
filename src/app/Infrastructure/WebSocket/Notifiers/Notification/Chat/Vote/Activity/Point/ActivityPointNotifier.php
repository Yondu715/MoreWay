<?php

namespace App\Infrastructure\WebSocket\Notifiers\Notification\Chat\Vote\Activity\Point;

use App\Application\Contracts\Out\Managers\Notifier\INotifierManager;
use App\Infrastructure\Broker\RabbitMqPublisher;
use App\Infrastructure\Http\Resources\Route\Point\PointResource;

use App\Infrastructure\WebSocket\Notifiers\Notification\BaseNotifier;

class ActivityPointNotifier extends BaseNotifier implements INotifierManager
{
    public function __construct(
        RabbitMqPublisher $publisher
    ) {
        parent::__construct($publisher, PointResource::class, "votes/routePoint");
    }
}
