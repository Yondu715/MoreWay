<?php

namespace App\Infrastructure\Http\Controllers\Api\V1;

use Illuminate\Http\Response;
use App\Utils\Mappers\In\User\GetUsersDtoMapper;
use App\Application\Exceptions\User\UserNotFound;
use App\Infrastructure\Http\Controllers\Controller;
use App\Utils\Mappers\In\User\ChangeUserDataDtoMapper;
use App\Application\Exceptions\User\InvalidOldPassword;
use App\Infrastructure\Http\Resources\User\UserResource;
use App\Utils\Mappers\In\User\ChangeUserAvatarDtoMapper;
use App\Infrastructure\Http\Requests\User\GetUsersRequest;
use App\Utils\Mappers\In\User\ChangeUserPasswordDtoMapper;
use App\Application\Contracts\In\Services\User\IUserService;
use App\Infrastructure\Http\Requests\User\ChangeUserDataRequest;
use App\Infrastructure\Http\Requests\User\ChangeUserAvatarRequest;
use App\Infrastructure\Http\Requests\User\ChangeUserPasswordRequest;
use App\Infrastructure\Http\Resources\User\ExtendedUserCursorResource;

class UserController extends Controller
{

    public function __construct(
        private readonly IUserService $userService
    ) {
    }

    /**
     * @param GetUsersRequest $getUsersRequest
     * @return ExtendedUserCursorResource
     */
    public function getUsers(GetUsersRequest $getUsersRequest): ExtendedUserCursorResource
    {
        $getUsersDto = GetUsersDtoMapper::fromRequest($getUsersRequest);
        return ExtendedUserCursorResource::make(
            $this->userService->getUsers($getUsersDto)
        );
    }

    /**
     * @param int $userId
     * @return UserResource
     * @throws UserNotFound
     */
    public function getUser(int $userId): UserResource
    {
        return UserResource::make(
            $this->userService->getUserById($userId)
        );
    }

    /**
     * @param ChangeUserDataRequest $changeUserDataRequest
     * @return UserResource
     * @throws UserNotFound
     */
    public function changeData(ChangeUserDataRequest $changeUserDataRequest): UserResource
    {
        $changeUserDataDto = ChangeUserDataDtoMapper::fromRequest($changeUserDataRequest);
        $this->userService->changeData($changeUserDataDto);
        return UserResource::make(
            $this->userService->changeData($changeUserDataDto)
        );
    }

    /**
     * @param int $userId
     * @return Response
     */
    public function delete(int $userId): Response
    {
        $this->userService->deleteUserById($userId);
        return response()->noContent();
    }

    /**
     * @param ChangeUserAvatarRequest $changeUserAvatarRequest
     * @return UserResource
     * @throws UserNotFound
     */
    public function changeAvatar(ChangeUserAvatarRequest $changeUserAvatarRequest): UserResource
    {
        $changeUserAvatarDto = ChangeUserAvatarDtoMapper::fromRequest($changeUserAvatarRequest);
        return UserResource::make(
            $this->userService->changeAvatar($changeUserAvatarDto)
        );
    }

    /**
     * @param ChangeUserPasswordRequest $changeUserPasswordRequest
     * @return UserResource
     * @throws UserNotFound
     * @throws InvalidOldPassword
     */
    public function changePassword(ChangeUserPasswordRequest $changeUserPasswordRequest): UserResource
    {
        $changeUserPasswordDto = ChangeUserPasswordDtoMapper::fromRequest($changeUserPasswordRequest);
        return UserResource::make(
            $this->userService->changePassword($changeUserPasswordDto)
        );
    }
}
