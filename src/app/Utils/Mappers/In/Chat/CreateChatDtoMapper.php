<?php

namespace App\Utils\Mappers\In\Chat;

use App\Application\DTO\In\Chat\CreateChatDto;
use App\Infrastructure\Http\Requests\Chat\CreateChatRequest;

class CreateChatDtoMapper
{
    /**
     * @param CreateChatRequest $createChatRequest
     * @return CreateChatDto
     */
    public static function fromRequest(CreateChatRequest $createChatRequest): CreateChatDto
    {
        return new CreateChatDto(
            name: $createChatRequest->name,
            creatorId: $createChatRequest->userId,
            routeId: $createChatRequest->routeId,
            members: array_map(function ($member) {
                return $member['id'];
            }, $createChatRequest->members),
        );
    }
}
