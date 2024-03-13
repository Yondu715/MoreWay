<?php

namespace App\DTO\User;

use App\Http\Requests\User\GetUsersRequest;

class GetUsersDto
{
    public readonly ?string $name;

    public function __construct(
        string $name
    ) {
        $this->name = $name;
    }

    /**
     * @param GetUsersRequest $getUsersRequest
     * @return self
     * 
     */
    public static function fromRequest(GetUsersRequest $getUsersRequest): self
    {
        return new self(
            name: $getUsersRequest->name
        );
    }
}
