<?php

namespace App\Http\Controllers\Api\V1;

use App\DTO\User\ChangeUserAvatarDto;
use App\DTO\User\ChangeUserPasswordDto;
use App\DTO\User\FindUsersDto;
use App\Exceptions\User\InvalidOldPassword;
use App\Exceptions\User\UserNotFound;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\ChangeUserAvatarRequest;
use App\Http\Requests\User\ChangeUserDataRequest;
use App\Http\Requests\User\ChangeUserPasswordRequest;
use App\Http\Requests\User\FindUsersRequest;
use App\Models\User;
use App\Services\User\UserService;
use Illuminate\Http\Response;
use App\DTO\User\ChangeUserDataDto;

class UserController extends Controller
{

    public function __construct(
        private readonly UserService $userService
    ) {
    }

    /**
     * @param int $userId
     * @return User
     * @throws UserNotFound
     */
    public function getUser(int $userId): User
    {
        return $this->userService->getUserById($userId);
    }

    /**
     * @param ChangeUserDataRequest $changeUserDataRequest
     * @return void
     * @throws UserNotFound
     */
    public function changeData(ChangeUserDataRequest $changeUserDataRequest): void
    {
        $changeUserDataDto = ChangeUserDataDto::fromRequest($changeUserDataRequest);
        $this->userService->changeData($changeUserDataDto);
    }

    /**
     * @param int $userId
     * @return Response
     * @throws UserNotFound
     */
    public function delete(int $userId): Response
    {
        $this->userService->deleteUserById($userId);
        return response()->noContent();
    }

    /**
     * @param ChangeUserAvatarRequest $changeUserAvatarRequest
     * @return void
     * @throws UserNotFound
     */
    public function changeAvatar(ChangeUserAvatarRequest $changeUserAvatarRequest): void
    {
        $changeUserAvatarDto = ChangeUserAvatarDto::fromRequest($changeUserAvatarRequest);
        $this->userService->changeAvatar($changeUserAvatarDto);

    }

    /**
     * @param ChangeUserPasswordRequest $changeUserPasswordRequest
     * @return User
     * @throws UserNotFound
     * @throws InvalidOldPassword
     */
    public function changePassword(ChangeUserPasswordRequest $changeUserPasswordRequest): User
    {
        $changeUserPasswordDto = ChangeUserPasswordDto::fromRequest($changeUserPasswordRequest);
        return $this->userService->changePassword($changeUserPasswordDto);
    }

    /**
     * @param FindUsersRequest $findUsersRequest
     * @return void
     */
    public function findUsers(FindUsersRequest $findUsersRequest): void
    {
        $findUsersDto = FindUsersDto::fromRequest($findUsersRequest);
        $this->userService->findUsersByName($findUsersDto->name);
    }
}
