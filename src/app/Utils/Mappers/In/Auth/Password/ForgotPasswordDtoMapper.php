<?php

namespace App\Utils\Mappers\In\Auth\Password;

use App\Application\DTO\In\Auth\Password\ForgotPasswordDto;
use App\Infrastructure\Http\Requests\Auth\Password\ForgotPasswordRequest;

class ForgotPasswordDtoMapper
{
    /**
     * @param ForgotPasswordRequest $forgotPasswordRequest
     * @return ForgotPasswordDto
     */
    public static function fromRequest(ForgotPasswordRequest $forgotPasswordRequest): ForgotPasswordDto
    {
        return new ForgotPasswordDto(
            email: $forgotPasswordRequest->email,
        );
    }
}