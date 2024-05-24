<?php

namespace App\Infrastructure\WebSocket\Notifiers\Notification\Achievement;

use App\Application\Contracts\Out\Managers\Notifier\INotifierManager;
use App\Infrastructure\Broker\RabbitMqPublisher;
use App\Infrastructure\Http\Resources\Achievement\AchievementResource;
use App\Infrastructure\WebSocket\Notifiers\Notification\BaseNotifier;

class AchievementNotifier extends BaseNotifier implements INotifierManager
{
    public function __construct(
        RabbitMqPublisher $publisher
    ) {
        parent::__construct($publisher, AchievementResource::class, "achievement");
    }
}
