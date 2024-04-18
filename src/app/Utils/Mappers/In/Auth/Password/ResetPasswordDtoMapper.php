<?php

namespace App\Utils\Mappers\In\Auth\Password;

use App\Application\DTO\In\Auth\Password\ResetPasswordDto;
use App\Infrastructure\Http\Requests\Auth\Password\ResetPasswordRequest;

class ResetPasswordDtoMapper
{
    public static function fromRequest(ResetPasswordRequest $resetPasswordRequest): ResetPasswordDto
    {
        return new ResetPasswordDto(
            email: $resetPasswordRequest->email,
            password: $resetPasswordRequest->password,
            token: $resetPasswordRequest->token
        );
    } 
}