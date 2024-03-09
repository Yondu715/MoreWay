<?php

namespace App\DTO\User;

use App\Http\Requests\User\FindUsersRequest;

class FindUsersDto
{
    public readonly string $name;

    public static function fromRequest(FindUsersRequest $findUsersRequest): self
    {
        $dto = new self();

        $dto->name = $findUsersRequest->name;
        return $dto;
    }
}
