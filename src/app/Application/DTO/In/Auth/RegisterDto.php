<?php

namespace App\Application\DTO\In\Auth;

use App\Infrastructure\Http\Requests\Auth\RegisterRequest;

class RegisterDto
{
    public readonly string $name;
    public readonly string $email;
    public readonly string $password;

    public function __construct(
        string $name,
        string $email,
        string $password
    ) {
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
    }

}
