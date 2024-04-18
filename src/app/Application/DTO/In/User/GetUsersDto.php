<?php

namespace App\Application\DTO\In\User;

class GetUsersDto
{
    public readonly ?string $name;

    public function __construct(
        ?string $name
    ) {
        $this->name = $name;
    }

}
