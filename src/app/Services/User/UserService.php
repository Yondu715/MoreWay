<?php

namespace App\Services\User;

use App\DTO\In\User\ChangeUserAvatarDto;
use App\DTO\In\User\ChangeUserDataDto;
use App\DTO\In\User\ChangeUserPasswordDto;
use App\DTO\In\User\GetUsersDto;
use App\DTO\Out\Auth\UserDto;
use App\Enums\Storage\Paths;
use App\Exceptions\User\InvalidOldPassword;
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
     * @return Collection<int,UserDto>
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
     */
    public function getUserById(int $userId): UserDto
    {
        /** @var User $user*/
        $user = $this->userRepository->findById($userId);
        return UserDto::fromUserModel($user);
    }

    /**
     * @param int $userId
     * @return ?bool
     */
    public function deleteUserById(int $userId): ?bool
    {
        return $this->userRepository->deleteById($userId);
    }

    /**
     * @param ChangeUserPasswordDto $changeUserPasswordDto
     * @throws InvalidOldPassword
     * @return UserDto
     */
    public function changePassword(ChangeUserPasswordDto $changeUserPasswordDto): UserDto
    {
        /** @var ?User $user */
        $user = $this->userRepository->findById($changeUserPasswordDto->userId);
        if (!Hash::check($changeUserPasswordDto->oldPassword, $user->password)) {
            throw new InvalidOldPassword();
        }

        /** @var User $updateUser*/
        $updateUser = $this->userRepository->update($user->id, [
            'password' => $changeUserPasswordDto->newPassword
        ]);
        return UserDto::fromUserModel($updateUser);
    }

    /**
     * @param ChangeUserAvatarDto $changeUserAvatarDto
     * @return UserDto
     */
    public function changeAvatar(ChangeUserAvatarDto $changeUserAvatarDto): UserDto
    {
        $user = $this->userRepository->findById($changeUserAvatarDto->userId);
        $path = Paths::UserAvatar->value . "/$user->id.jpg";
        $this->storageManager->store($path, $changeUserAvatarDto->avatar);

        /** @var User $updateUser*/
        $updateUser = $this->userRepository->update($user->id, [
            'avatar' => $path
        ]);
        return UserDto::fromUserModel($updateUser);
    }

    /**
     * @param ChangeUserDataDto $changeUserDataDto
     * @return UserDto
     */
    public function changeData(ChangeUserDataDto $changeUserDataDto): UserDto
    {
        $user = $this->userRepository->findById($changeUserDataDto->userId);
        $data = collect($changeUserDataDto)->filter(function (?string $value) {
            return !is_null($value);
        })->toArray();

        /** @var User $updateUser*/
        $updateUser = $this->userRepository->update($user->id, $data);
        return UserDto::fromUserModel($updateUser);
    }
}
