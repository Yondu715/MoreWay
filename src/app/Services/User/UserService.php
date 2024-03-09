<?php

namespace App\Services\User;

use App\Dto\User\ChangeUserAvatarDto;
use App\Dto\User\ChangeUserPasswordDto;
use App\Enums\Storage\Paths;
use App\Exceptions\User\InvalidOldPassword;
use App\Exceptions\User\UserNotFound;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Src\App\Dto\User\ChangeUserDataDto;

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
        if (Storage::exists($path)) {
            Storage::delete($path);
        }
        Storage::put($path, $changeUserAvatarDto->avatar);
        $user->update([
            'avatar' => $path
        ]);
        return $user->refresh();
    }

    public function findUsersByName(string $name): Collection
    {
        return User::query()->where('name', 'like', $name . '%')->get();
    }

    public function changeData(ChangeUserDataDto $changeUserDataDto): User
    {
        /**@var User */
        $user = User::query()->find($changeUserDataDto->userId);
        if (!$user) {
            throw new UserNotFound();
        }
        $data = collect($changeUserDataDto)->filter(function ($value) {
            return $value !== null;
        })->toArray();
        $user->update($data);
        return $user->refresh();
    }
}
