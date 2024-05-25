<?php

namespace App\Utils\Mappers\In\Chat\Member;

use App\Application\DTO\In\Chat\Member\AddMembersDto;
use App\Infrastructure\Http\Requests\Chat\Member\AddMembersRequest;

class AddMembersDtoMapper
{
    /**
     * @param AddMembersRequest $addMembersRequest
     * @return AddMembersDto
     */
    public static function fromRequest(AddMembersRequest $addMembersRequest): AddMembersDto
    {
        return new AddMembersDto(
            chatId: $addMembersRequest->route('chatId'),
            members: $addMembersRequest->members,
        );
    }
}
