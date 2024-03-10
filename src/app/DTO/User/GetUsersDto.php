<?php

namespace App\Dto\User;

use App\Http\Requests\User\GetUsersRequest;

class GetUsersDto
{
    public readonly ?string $name;

    /**
     * @param GetUsersRequest $getUsersRequest
     * @return self
     * 
     */
    public static function fromRequest(GetUsersRequest $getUsersRequest): self
    {
        $dto = new self();

        $dto->name = $getUsersRequest->name;
        return $dto;
    }
}
