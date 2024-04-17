<?php

namespace App\Utils\Mappers\In\User;

use App\Application\DTO\In\User\ChangeUserDataDto;
use App\Infrastructure\Http\Requests\User\ChangeUserDataRequest;

class ChangeUserDataDtoMapper
{
    /**
     * @param ChangeUserDataRequest $changeUserDataRequest
     * @return ChangeUserDataDto
     */
    public static function fromRequest(ChangeUserDataRequest $changeUserDataRequest): ChangeUserDataDto
    {
        return new ChangeUserDataDto(
            userId: $changeUserDataRequest->route('userId'),
            name: $changeUserDataRequest->name
        );
    }
}