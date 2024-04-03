<?php

namespace App\Services\User;

use App\DTO\In\User\ChangeUserAvatarDto;
use App\DTO\In\User\ChangeUserDataDto;
use App\DTO\In\User\ChangeUserPasswordDto;
use App\DTO\In\User\GetUsersDto;
use App\DTO\Out\Auth\UserDto;
use App\Enums\Storage\Paths;
use App\Exceptions\User\InvalidOldPassword;
use App\Exceptions\User\UserNotFound;
use App\Lib\Storage\Interfaces\IStorageManager;
use App\Repositories\User\Interfaces\IUserRepository;
use App\Services\User\Interfaces\IUserService;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Collection;

class UserService implements IUserService
{

    public function __construct(
        private readonly IStorageManager $storageManager,
        private readonly IUserRepository $userRepository
    ) {
    }

    /**
     * @param GetUsersDto $getUsersDto
     * @return Collection<int,User>
     */
    public function getUsers(GetUsersDto $getUsersDto): Collection
    {
        $users = $getUsersDto->name ?
            $this->userRepository->getByName($getUsersDto->name) :
            $this->userRepository->all();
        return $users->map(function (User $user) {
            return UserDto::fromUserModel($user);
        });
    }

    /**
     * @param int $userId
     * @return UserDto
     * @throws UserNotFound
     */
    public function getUserById(int $userId): UserDto
    {
        return UserDto::fromUserModel(
            $this->userRepository->findById($userId)
        );
    }

    /**
     * @param int $userId
     * @return ?bool
     * @throws UserNotFound
     */
    public function deleteUserById(int $userId): ?bool
    {
        return $this->userRepository->deleteById($userId);
    }

    /**
     * @param ChangeUserPasswordDto $changeUserPasswordDto
     * @throws InvalidOldPassword
     * @throws UserNotFound
     * @return UserDto
     */
    public function changePassword(ChangeUserPasswordDto $changeUserPasswordDto): UserDto
    {
        /** @var ?User $user */
        $user = $this->userRepository->findById($changeUserPasswordDto->userId);
        if (!Hash::check($changeUserPasswordDto->oldPassword, $user->password)) {
            throw new InvalidOldPassword();
        }
        return UserDto::fromUserModel(
            $this->userRepository->update($user->id, [
                'password' => $changeUserPasswordDto->newPassword
            ])
        );
    }

    /**
     * @param ChangeUserAvatarDto $changeUserAvatarDto
     * @return UserDto
     * @throws UserNotFound
     */
    public function changeAvatar(ChangeUserAvatarDto $changeUserAvatarDto): UserDto
    {
        $user = $this->userRepository->findById($changeUserAvatarDto->userId);
        $path = Paths::UserAvatar->value . "/$user->id.jpg";
        $this->storageManager->store($path, $changeUserAvatarDto->avatar);
        return UserDto::fromUserModel(
            $this->userRepository->update($user->id, [
                'avatar' => $path
            ])
        );
    }

    /**
     * @param ChangeUserDataDto $changeUserDataDto
     * @return UserDto
     * @throws UserNotFound
     */
    public function changeData(ChangeUserDataDto $changeUserDataDto): UserDto
    {
        $user = $this->userRepository->findById($changeUserDataDto->userId);
        $data = collect($changeUserDataDto)->filter(function (?string $value) {
            return !is_null($value);
        })->toArray();
        return UserDto::fromUserModel(
            $this->userRepository->update($user->id, $data)
        );
    }
}
