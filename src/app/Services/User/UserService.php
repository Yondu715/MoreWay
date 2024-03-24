<?php

namespace App\Services\User;

use App\DTO\In\User\ChangeUserAvatarDto;
use App\DTO\In\User\ChangeUserDataDto;
use App\DTO\In\User\ChangeUserPasswordDto;
use App\DTO\In\User\GetUsersDto;
use App\Enums\Storage\Paths;
use App\Exceptions\User\InvalidOldPassword;
use App\Exceptions\User\UserNotFound;
use App\Lib\Storage\StorageManager;
use App\Models\User;
use App\Services\User\Interfaces\IUserService;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Hash;

class UserService implements IUserService
{

    /**
     * @param StorageManager $storageManager
     */
    public function __construct(
        private readonly StorageManager $storageManager
    ) {}

    /**
     * @param GetUsersDto $getUsersDto
     * @return Collection<int,User>
     *
     */
    public function getUsers(GetUsersDto $getUsersDto): Collection
    {
        return $getUsersDto->name ?
            User::query()->where('name', 'like', $getUsersDto->name . '%')->get() :
            User::all();
    }

    /**
     * @param int $userId
     * @return User
     * @throws UserNotFound
     */
    public function getUserById(int $userId): User
    {
        /** @var ?User $user */
        $user = User::query()->find($userId);
        if (!$user) {
            throw new UserNotFound();
        }
        return $user;
    }

    /**
     * @param int $userId
     * @return ?bool
     * @throws UserNotFound
     */
    public function deleteUserById(int $userId): ?bool
    {
        /** @var ?User $user */
        $user = User::query()->find($userId);
        if (!$user) {
            throw new UserNotFound();
        }
        return $user->delete();
    }

    /**
     * @param ChangeUserPasswordDto $changeUserPasswordDto
     * @return User
     * @throws InvalidOldPassword
     * @throws UserNotFound
     */
    public function changePassword(ChangeUserPasswordDto $changeUserPasswordDto): User
    {
        /** @var ?User $user */
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
        /** @var User */
        return $user->refresh();
    }

    /**
     * @param ChangeUserAvatarDto $changeUserAvatarDto
     * @return User
     * @throws UserNotFound
     */
    public function changeAvatar(ChangeUserAvatarDto $changeUserAvatarDto): User
    {
        /** @var ?User $user */
        $user = User::query()->find($changeUserAvatarDto->userId);
        if (!$user) {
            throw new UserNotFound();
        }
        $path = Paths::UserAvatar->value . "/$user->id.jpg";
        $this->storageManager->store($path, $changeUserAvatarDto->avatar);
        $user->update([
            'avatar' => $path
        ]);
        /**@var User */
        return $user->refresh();
    }

    /**
     * @param ChangeUserDataDto $changeUserDataDto
     * @return User
     * @throws UserNotFound
     */
    public function changeData(ChangeUserDataDto $changeUserDataDto): User
    {
        /** @var ?User $user */
        $user = User::query()->find($changeUserDataDto->userId);
        if (!$user) {
            throw new UserNotFound();
        }
        $data = collect($changeUserDataDto)->filter(function (string $value, string $key) {
            return $value !== null;
        })->toArray();
        $user->update($data);
        /** @var User */
        return $user->refresh();
    }
}
