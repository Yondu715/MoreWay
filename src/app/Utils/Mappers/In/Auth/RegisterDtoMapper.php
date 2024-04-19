<?php

namespace App\Utils\Mappers\In\Auth;

use App\Application\DTO\In\Auth\RegisterDto;
use App\Infrastructure\Http\Requests\Auth\RegisterRequest;

class RegisterDtoMapper
{
    /**
     * @param RegisterRequest $registerRequest
     * @return RegisterDto
     */
    public static function fromRequest(RegisterRequest $registerRequest): RegisterDto
    {
        return new RegisterDto(
            name: $registerRequest->name,
            email: $registerRequest->email,
            password: $registerRequest->password
        );
    }
}