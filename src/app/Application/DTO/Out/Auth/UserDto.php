<?php

namespace App\Infrastructure\Database\Models\Infrastructure\Database\Models\Application\DTO\Out\Auth;

use App\Infrastructure\Database\Models\Infrastructure\Database\Models\Infrastructure\Database\Models\User;

class UserDto
{
    public readonly int $id;
    public readonly string $name;
    public readonly string $avatar;
    public readonly string $email;

    public function __construct(
        int $id,
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
            id: $user->id,
            name: $user->name,
            avatar: $user->avatar,
            email: $user->email
        );
    }

}
