<?php

namespace App\Application\DTO\In\Auth\Password;

class ForgotPasswordDto
{
    public readonly string $email;

    public function __construct(
        string $email,
    ) {
        $this->email = $email;
    }

}
