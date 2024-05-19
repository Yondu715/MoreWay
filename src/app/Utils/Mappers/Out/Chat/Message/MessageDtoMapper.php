<?php

namespace App\Utils\Mappers\Out\Chat\Message;

use App\Application\DTO\Collection\CursorDto;
use App\Application\DTO\Out\Chat\Message\MessageDto;
use App\Infrastructure\Database\Models\ChatMessage;
use App\Utils\Mappers\Collection\CursorDtoMapper;
use App\Utils\Mappers\Out\User\UserDtoMapper;
use Illuminate\Pagination\CursorPaginator;
use Illuminate\Support\Collection;

class MessageDtoMapper
{
    /**
     * @param ChatMessage $message
     * @return MessageDto
     */
    public static function fromMessageModel(ChatMessage $message): MessageDto
    {
        return new MessageDto(
            id: $message->id,
            message: $message->text,
            createdAt: $message->created_at->format('Y-m-d H:i:s'),
            sender: UserDtoMapper::fromUserModelToNotify($message->sender),
        );
    }

    /**
     * @param Collection $messages
     * @return Collection
     */
    public static function fromChatMessageCollection(Collection $messages): Collection
    {
        return $messages->map(function (ChatMessage $message) {
            return self::fromMessageModel($message);
        });
    }

    /**
     * @param CursorPaginator $paginator
     * @return CursorDto
     */
    public static function fromPaginator(CursorPaginator $paginator): CursorDto
    {
        return CursorDtoMapper::fromPaginatorAndMapper($paginator, function ($message) {
            return self::fromMessageModel($message);
        });
    }
}
