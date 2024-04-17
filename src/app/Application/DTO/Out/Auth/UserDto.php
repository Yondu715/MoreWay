<?php

namespace App\Application\DTO\Out\Auth;

class UserDto
{
    public readonly int $id;
    public readonly string $name;
    public readonly string $avatar;
    public readonly string $email;

    public function __construct(
        int $id,
        string $name,
        string $avatar,
        string $email
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->avatar = $avatar;
        $this->email = $email;
    }
}
