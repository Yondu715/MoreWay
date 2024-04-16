<?php

namespace App\Application\DTO\In\Auth\Password;

use App\Infrastructure\Http\Requests\Auth\Password\ResetPasswordRequest;

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

    public static function fromRequest(ResetPasswordRequest $resetPasswordRequest): self
    {
        return new self(
            email: $resetPasswordRequest->email,
            password: $resetPasswordRequest->password,
            token: $resetPasswordRequest->token
        );
    }
}
