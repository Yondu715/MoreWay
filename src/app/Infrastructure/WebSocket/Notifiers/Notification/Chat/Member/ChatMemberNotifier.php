<?php

namespace App\Infrastructure\WebSocket\Notifiers\Notification\Chat\Member;

use App\Application\Contracts\Out\Managers\Notifier\INotifierManager;
use App\Infrastructure\Broker\RabbitMqPublisher;
use App\Infrastructure\Http\Resources\User\UserCollectionResource;
use App\Infrastructure\WebSocket\Notifiers\Notification\BaseNotifier;

class ChatMemberNotifier extends BaseNotifier implements INotifierManager
{
    public function __construct(
        RabbitMqPublisher $publisher
    ) {
        parent::__construct($publisher, UserCollectionResource::class, "chatMember");
    }
}
