<?php

namespace App\Infrastructure\WebSocket\Notifiers\Notification\Chat\Member;

use App\Infrastructure\Broker\RabbitMqPublisher;
use App\Infrastructure\Http\Resources\User\ShortUserResource;
use App\Application\Contracts\Out\Managers\Notifier\INotifierManager;
use App\Infrastructure\WebSocket\Notifiers\Notification\BaseNotifier;

class ChatMemberNotifier extends BaseNotifier implements INotifierManager
{
    public function __construct(
        RabbitMqPublisher $publisher
    ) {
        parent::__construct($publisher, ShortUserResource::class, "chats/member");
    }
}
