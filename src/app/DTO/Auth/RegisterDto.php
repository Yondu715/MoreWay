<?php

namespace App\DTO\Auth;

use App\Http\Requests\Auth\RegisterRequest;

class RegisterDto
{
    public readonly string $name;
    public readonly string $email;
    public readonly string $password;

    /**
     * @param RegisterRequest $registerRequest
     * @return self
     */
    public static function fromRequest(RegisterRequest $registerRequest): self
    {
        $dto = new self();

        $dto->name = $registerRequest->name;
        $dto->email = $registerRequest->email;
        $dto->password = $registerRequest->password;

        return $dto;
    }
}
