<?php

namespace App\DTO\In\Auth\Password;

use App\Http\Requests\Auth\Password\VerifyPasswordCodeRequest;

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

    public static function fromRequest(VerifyPasswordCodeRequest $verifyPasswordCodeRequest): self
    {
        return new self(
            email: $verifyPasswordCodeRequest->email,
            code: $verifyPasswordCodeRequest->code
        );
    }
}
