<?php

namespace App\Services\User;

use App\Dto\User\ChangeUserAvatarDto;
use App\Dto\User\ChangeUserPasswordDto;
use App\Enums\Storage\Paths;
use App\Exceptions\User\InvalidOldPassword;
use App\Exceptions\User\UserNotFound;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserService
{

    public function getUserById(int $userId): User
    {
        /**@var User */
        $user = User::query()->find($userId);
        if (!$user) {
            throw new UserNotFound();
        }
        return $user;
    }

    public function deleteUserById(int $userId): ?bool
    {
        /**@var User */
        $user = User::query()->find($userId);
        if (!$user) {
            throw new UserNotFound();
        }
        return $user->delete();
    }

    public function changePassword(ChangeUserPasswordDto $changeUserPasswordDto): User
    {
        /**@var User */
        $user = User::query()->find($changeUserPasswordDto->userId);
        if (!$user) {
            throw new UserNotFound();
        }
        if (!Hash::check($changeUserPasswordDto->oldPassword, $user->password)) {
            throw new InvalidOldPassword();
        }
        $user->update([
            'password' => $changeUserPasswordDto->newPassword
        ]);
        return $user->refresh();
    }

    public function changeAvatar(ChangeUserAvatarDto $changeUserAvatarDto): User
    {
        /**@var User */
        $user = User::query()->find($changeUserAvatarDto->userId);
        if (!$user) {
            throw new UserNotFound();
        }
        $path = Paths::UserAvatar->value . "/$user->id.jpg";
        $changeUserAvatarDto->avatar->store($path);
        $user->update([
            'avatar' => $path
        ]);
        return $user->refresh();
    }
}
