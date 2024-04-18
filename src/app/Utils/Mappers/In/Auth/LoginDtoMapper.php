<?php

namespace App\Utils\Mappers\In\Auth;

use App\Application\DTO\In\Auth\LoginDto;
use App\Infrastructure\Http\Requests\Auth\LoginRequest;

class LoginDtoMapper
{
    /**
     * @param LoginRequest $loginRequest
     * @return LoginDto
     */
    public static function fromRequest(LoginRequest $loginRequest): LoginDto
    {
        return new LoginDto(
            email: $loginRequest->email,
            password: $loginRequest->password
        );
    }
}