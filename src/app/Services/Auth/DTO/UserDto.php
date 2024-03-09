<?php

namespace App\Services\Auth\DTO;

use App\Lib\HashId\HashManager;
use App\Models\User;

class UserDto
{
    public readonly string $id;
    public readonly string $name;
    public readonly string $avatar;
    public readonly string $email;

    /**
     * @param User $user
     * @return self
     */
    public static function fromUserModel(User $user): self
    {
        $dto = new self();

        $dto->id = HashManager::encrypt($user->id);
        $dto->name = $user->name;
        $dto->avatar = $user->avatar;
        $dto->email = $user->email;

        return $dto;
    }
}
