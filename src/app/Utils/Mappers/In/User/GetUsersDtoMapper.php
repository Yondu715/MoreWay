<?php

namespace App\Utils\Mappers\In\User;

use App\Application\DTO\In\User\GetUsersDto;
use App\Infrastructure\Http\Requests\User\GetUsersRequest;

class GetUsersDtoMapper
{
    /**
     * @param GetUsersRequest $getUsersRequest
     * @return GetUsersDto
     */
    public static function fromRequest(GetUsersRequest $getUsersRequest): GetUsersDto
    {
        return new GetUsersDto(
            cursor: $getUsersRequest->cursor,
            limit: $getUsersRequest->limit,
            filter: [
                'name' => $getUsersRequest->name
            ]
        );
    }
}