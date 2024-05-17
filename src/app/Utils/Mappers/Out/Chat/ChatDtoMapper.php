<?php

namespace App\Utils\Mappers\Out\Chat;

use App\Application\DTO\Out\Chat\ChatDto;
use App\Infrastructure\Database\Models\Chat;
use App\Utils\Mappers\Out\Auth\UserDtoMapper;
use App\Utils\Mappers\Out\Route\RouteDtoMapper;

class ChatDtoMapper
{
    public static function fromChatModel(Chat $chat): ChatDto
    {
        return new ChatDto(
            id: $chat->id,
            name: $chat->name,
            creator: UserDtoMapper::fromUserModelToNotify($chat->creator),
            members: UserDtoMapper::fromChatMemberCollection($chat->members),
            activity: RouteDtoMapper::fromRouteModel($chat->activeRoute->route)
        );
    }
}
