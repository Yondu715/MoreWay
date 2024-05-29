<?php

namespace App\Application\DTO\Out\User;

class UserDto
{
    public readonly int $id;
    public readonly string $name;
    public readonly string $avatar;
    public readonly string $email;
    public readonly string $password;

    public function __construct(
        int $id,
        string $name,
        string $avatar,
        string $email,
        string $password
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->avatar = $avatar;
        $this->email = $email;
        $this->password = $password;
    }
}
