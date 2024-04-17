<?php

namespace App\Application\DTO\In\Auth\Password;

class ResetPasswordDto
{
    public readonly string $email;
    public readonly string $password;
    public readonly string $token;

    public function __construct(
        string $email,
        string $password,
        string $token
    ) {
        $this->email = $email;
        $this->password =$password;
        $this->token = $token;
    }

}
