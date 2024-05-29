<?php

namespace App\Application\Services\User;

use App\Application\Contracts\In\Services\User\IUserService;
use App\Application\Contracts\Out\Managers\Hash\IHashManager;
use App\Application\Contracts\Out\Managers\Storage\IStorageManager;
use App\Application\Contracts\Out\Managers\Token\ITokenManager;
use App\Application\Contracts\Out\Repositories\Friend\IFriendshipRepository;
use App\Application\Contracts\Out\Repositories\User\IUserRepository;
use App\Application\DTO\Collection\CursorDto;
use App\Application\DTO\In\User\ChangeUserAvatarDto;
use App\Application\DTO\In\User\ChangeUserDataDto;
use App\Application\DTO\In\User\ChangeUserPasswordDto;
use App\Application\DTO\In\User\GetUsersDto;
use App\Application\DTO\Out\User\ExtendedUserDto;
use App\Application\DTO\Out\User\UserDto;
use App\Application\Enums\Storage\StoragePath;
use App\Application\Exceptions\User\InvalidOldPassword;

class UserService implements IUserService
{

    public function __construct(
        private readonly IStorageManager $storageManager,
        private readonly IUserRepository $userRepository,
        private readonly IHashManager $hashManager,
        private readonly IFriendshipRepository $friendshipRepository,
        private readonly ITokenManager $tokenManager
    ) {
    }

    /**
     * @param GetUsersDto $getUsersDto
     * @return CursorDto
     */
    public function getUsers(GetUsersDto $getUsersDto): CursorDto
    {
        $users = $this->userRepository->getAll($getUsersDto);
        $friendShips = $this->friendshipRepository->getUserFriendships($this->tokenManager->getAuthUser()->id);

        $extendedUsers = $users->data->map(function (UserDto $userDto) use ($friendShips) {
            $friend = $friendShips->first(fn (UserDto $friend) => $friend->id === $userDto->id);
            return new ExtendedUserDto(
                $userDto,
                $friend ? true : false
            );
        });

        return new CursorDto(
            $extendedUsers,
            $users->cursor
        );;
    }

    /**
     * @param int $userId
     * @return UserDto
     */
    public function getUserById(int $userId): UserDto
    {
        return $this->userRepository->findById($userId);
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
        $user = $this->userRepository->findById($changeUserPasswordDto->userId);
        if (!$this->hashManager->check($changeUserPasswordDto->oldPassword, $user->password)) {
            throw new InvalidOldPassword();
        }

        return $this->userRepository->updatePassword($changeUserPasswordDto->userId, $changeUserPasswordDto->newPassword);
    }

    /**
     * @param ChangeUserAvatarDto $changeUserAvatarDto
     * @return UserDto
     */
    public function changeAvatar(ChangeUserAvatarDto $changeUserAvatarDto): UserDto
    {
        $user = $this->userRepository->findById($changeUserAvatarDto->userId);
        $path = StoragePath::UserAvatar->value . "/$user->id." . $changeUserAvatarDto->avatar->getClientOriginalExtension();

        $this->storageManager->store($path, $changeUserAvatarDto->avatar);

        return $this->userRepository->updateAvatar($user->id, $path);
    }

    /**
     * @param ChangeUserDataDto $changeUserDataDto
     * @return UserDto
     */
    public function changeData(ChangeUserDataDto $changeUserDataDto): UserDto
    {
        return $this->userRepository->update($changeUserDataDto);
    }
}
