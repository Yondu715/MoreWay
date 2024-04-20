<?php

namespace App\Application\Services\User;

use App\Application\Contracts\In\Services\User\IUserService;
use App\Application\Contracts\Out\Managers\Hash\IHashManager;
use App\Application\Contracts\Out\Managers\Storage\IStorageManager;
use App\Application\Contracts\Out\Repositories\User\IUserRepository;
use App\Application\DTO\In\User\ChangeUserAvatarDto;
use App\Application\DTO\In\User\ChangeUserDataDto;
use App\Application\DTO\In\User\ChangeUserPasswordDto;
use App\Application\DTO\In\User\GetUsersDto;
use App\Application\DTO\Out\Auth\UserDto;
use App\Application\Enums\Storage\StoragePaths;
use App\Application\Exceptions\User\InvalidOldPassword;
use App\Infrastructure\Database\Models\User;
use App\Utils\Mappers\Out\Auth\UserDtoMapper;
use Illuminate\Support\Collection;

class UserService implements IUserService
{

    public function __construct(
        private readonly IStorageManager $storageManager,
        private readonly IUserRepository $userRepository,
        private readonly IHashManager $hashManager
    ) {
    }

    /**
     * @param GetUsersDto $getUsersDto
     * @return Collection<int,UserDto>
     */
    public function getUsers(GetUsersDto $getUsersDto): Collection
    {
        $users = $this->userRepository->getUsers($getUsersDto);
        return $users->map(function (User $user) {
            return UserDtoMapper::fromUserModel($user);
        });
    }

    /**
     * @param int $userId
     * @return UserDto
     */
    public function getUserById(int $userId): UserDto
    {
        /** @var User $user */
        $user = $this->userRepository->findById($userId);
        return UserDtoMapper::fromUserModel($user);
    }

    /**
     * @param int $userId
     * @return bool
     */
    public function deleteUserById(int $userId): bool
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
        /** @var User $user */
        $user = $this->userRepository->findById($changeUserPasswordDto->userId);
        if (!$this->hashManager->check($changeUserPasswordDto->oldPassword, $user->password)) {
            throw new InvalidOldPassword();
        }

        /** @var User $updatedUser */
        $updatedUser = $this->userRepository->update($user->id, [
            'password' => $changeUserPasswordDto->newPassword
        ]);
        return UserDtoMapper::fromUserModel($updatedUser);
    }

    /**
     * @param ChangeUserAvatarDto $changeUserAvatarDto
     * @return UserDto
     */
    public function changeAvatar(ChangeUserAvatarDto $changeUserAvatarDto): UserDto
    {
        /** @var User $user */
        $user = $this->userRepository->findById($changeUserAvatarDto->userId);
        $path = StoragePaths::UserAvatar->value . "/$user->id.jpg";
        $this->storageManager->store($path, $changeUserAvatarDto->avatar);

        /** @var User $updatedUser*/
        $updatedUser = $this->userRepository->update($user->id, [
            'avatar' => $path
        ]);
        return UserDtoMapper::fromUserModel($updatedUser);
    }

    /**
     * @param ChangeUserDataDto $changeUserDataDto
     * @return UserDto
     */
    public function changeData(ChangeUserDataDto $changeUserDataDto): UserDto
    {
        /** @var User $user */
        $user = $this->userRepository->findById($changeUserDataDto->userId);
        $data = collect($changeUserDataDto)->filter(function (?string $value) {
            return !is_null($value);
        })->toArray();

        /** @var User $updatedUser */
        $updatedUser = $this->userRepository->update($user->id, $data);
        return UserDtoMapper::fromUserModel($updatedUser);
    }
}
