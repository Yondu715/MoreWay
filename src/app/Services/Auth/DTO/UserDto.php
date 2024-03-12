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

    public function __construct(
        string $id,
        string $name,
        string $avatar,
        string $email
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->avatar = $avatar;
        $this->email = $email;
    }

    /**
     * @param User $user
     * @return self
     */
    public static function fromUserModel(User $user): self
    {
        return new self(
            id: HashManager::encrypt($user->id),
            name: $user->name,
            avatar: $user->avatar,
            email: $user->email
        );
    }
}
