<?php

namespace App\Utils\Mappers\Out\Chat;

use App\Application\DTO\Collection\CursorDto;
use App\Application\DTO\Out\Chat\ChatDto;
use App\Infrastructure\Database\Models\Chat;
use App\Utils\Mappers\Collection\CursorDtoMapper;
use App\Utils\Mappers\Out\User\UserDtoMapper;
use App\Utils\Mappers\Out\Chat\Message\MessageDtoMapper;
use App\Utils\Mappers\Out\Route\RouteDtoMapper;
use Illuminate\Pagination\CursorPaginator;

class ChatDtoMapper
{
    /**
     * @param Chat $chat
     * @return ChatDto
     */
    public static function fromChatModel(Chat $chat): ChatDto
    {
        return new ChatDto(
            id: $chat->id,
            name: $chat->name,
            isActive: $chat->is_active,
            creator: UserDtoMapper::fromUserModelToNotify($chat->creator),
            members: UserDtoMapper::fromChatMemberCollection($chat->members),
            messages: MessageDtoMapper::fromChatMessageCollection($chat->messages),
            activity: RouteDtoMapper::fromRouteModel($chat->activeRoute->route)
        );
    }

    /**
     * @param CursorPaginator $paginator
     * @return CursorDto
     */
    public static function fromPaginator(CursorPaginator $paginator): CursorDto
    {
        return CursorDtoMapper::fromPaginatorAndMapper($paginator, function (Chat $chat) {
            return self::fromChatModel($chat);
        });
    }
}
