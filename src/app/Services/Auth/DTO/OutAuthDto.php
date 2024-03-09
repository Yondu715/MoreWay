<?php

namespace App\Services\Auth\DTO;

/**
 * @property UserDto $user
 * @property string $token
 */
class OutAuthDto
{
    public readonly UserDto $user;
    public readonly string $token;

    /**
     * @param UserDto $user
     * @param string $token
     * @return self
     */
    public static function fromArray(UserDto $user, string $token): self
    {
        $dto = new self();

        $dto->user = $user;
        $dto->token = $token;

        return $dto;
    }
}
