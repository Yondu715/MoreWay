<?php

namespace App\Utils\Mappers\In\Route;

use App\Application\DTO\In\Route\GetUserRoutesDto;
use App\Infrastructure\Http\Requests\Route\GetUserRoutesRequest;

class GetUserRoutesDtoMapper
{
    /**
     * @param GetUserRoutesRequest $getUserRoutesRequest
     * @return GetUserRoutesDto
     */
    public static function fromRequest(GetUserRoutesRequest $getUserRoutesRequest): GetUserRoutesDto
    {
        return new GetUserRoutesDto(
            cursor: $getUserRoutesRequest->cursor,
            userId: $getUserRoutesRequest->route('userId'),
            limit: $getUserRoutesRequest->limit
        );
    }
}
