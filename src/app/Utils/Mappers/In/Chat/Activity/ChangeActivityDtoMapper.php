<?php

namespace App\Utils\Mappers\In\Chat\Activity;

use App\Application\DTO\In\Chat\Activity\ChangeActivityDto;
use App\Infrastructure\Http\Requests\Chat\Activity\ChangeActivityRequest;

class ChangeActivityDtoMapper
{
    /**
     * @param ChangeActivityRequest $getUserChatsRequest
     * @return ChangeActivityDto
     */
    public static function fromRequest(ChangeActivityRequest $getUserChatsRequest): ChangeActivityDto
    {
        return new ChangeActivityDto(
            chatId: $getUserChatsRequest->route('chatId'),
            routeId: $getUserChatsRequest->routeId,
        );
    }
}
