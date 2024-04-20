<?php

namespace App\Utils\Mappers\In\Auth\Password;

use App\Application\DTO\In\Auth\Password\VerifyPasswordCodeDto;
use App\Infrastructure\Http\Requests\Auth\Password\VerifyPasswordCodeRequest;

class VerifyPasswordCodeDtoMapper
{
    /**
     * @param VerifyPasswordCodeRequest $verifyPasswordCodeRequest
     * @return VerifyPasswordCodeDto
     */
    public static function fromRequest(VerifyPasswordCodeRequest $verifyPasswordCodeRequest): VerifyPasswordCodeDto
    {
        return new VerifyPasswordCodeDto(
            email: $verifyPasswordCodeRequest->email,
            code: $verifyPasswordCodeRequest->code
        );
    }
}
