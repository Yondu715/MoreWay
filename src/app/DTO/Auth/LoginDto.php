<?php

namespace App\DTO\Auth;

use App\Http\Requests\Auth\LoginRequest;

class LoginDto
{
    public readonly string $email;
    public readonly string $password;

    /**
     * @param LoginRequest $loginRequest
     * @return self
     */
    public static function fromRequest(LoginRequest $loginRequest): self
    {
        $dto = new self();

        $dto->email = $loginRequest->email;
        $dto->password = $loginRequest->password;

        return $dto;
    }
}
