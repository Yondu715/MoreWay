<?php

namespace App\Infrastructure\Database\Models\Infrastructure\Database\Models\Application\DTO\In\User;

use App\Infrastructure\Database\Models\Infrastructure\Database\Models\Infrastructure\Http\Requests\User\GetUsersRequest;

class GetUsersDto
{
    public readonly ?string $name;

    public function __construct(
        ?string $name
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
