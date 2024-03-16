<?php

namespace App\DTO\In\Auth;

use App\Http\Requests\Auth\RegisterRequest;

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

    /**
     * @param RegisterRequest $registerRequest
     * @return self
     */
    public static function fromRequest(RegisterRequest $registerRequest): self
    {
        return new self(
            name: $registerRequest->name,
            email: $registerRequest->email,
            password: $registerRequest->password
        );
    }
}
