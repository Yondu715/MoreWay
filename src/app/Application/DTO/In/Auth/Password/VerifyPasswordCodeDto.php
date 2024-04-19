<?php

namespace App\Application\DTO\In\Auth\Password;

class VerifyPasswordCodeDto
{
    public readonly string $email;
    public readonly string $code;

    public function __construct(
        string $email,
        string $code
    ) {
        $this->email = $email;
        $this->code = $code;
    }

}
