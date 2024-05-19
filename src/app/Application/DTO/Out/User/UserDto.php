<?php

namespace App\Application\DTO\Out\User;

class UserDto
{
    public readonly ?int $id;
    public readonly ?string $name;
    public readonly ?string $avatar;
    public readonly ?string $email;
    public readonly ?string $password;

    public function __construct(
        ?int $id = null,
        ?string $name = null,
        ?string $avatar = null,
        ?string $email = null,
        ?string $password = null
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->avatar = $avatar;
        $this->email = $email;
        $this->password = $password;
    }
}
