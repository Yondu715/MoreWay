<?php

namespace App\DTO\In\Auth;

use App\Http\Requests\Auth\ForgotPasswordRequest;

class ForgotPasswordDto
{
    public readonly string $email;

    public function __construct(
        string $email,
    ) {
        $this->email = $email;
    }

    /**
     * @param ForgotPasswordRequest $forgotPasswordRequest
     * @return self
     */
    public static function fromRequest(ForgotPasswordRequest $forgotPasswordRequest): self
    {
        return new self(
            email: $forgotPasswordRequest->email,
        );
    }
}
