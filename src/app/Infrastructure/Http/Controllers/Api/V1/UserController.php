<?php

namespace App\Infrastructure\Http\Controllers\Api\V1;

use App\Application\Contracts\In\Services\User\IUserService;
use App\Application\Exceptions\User\InvalidOldPassword;
use App\Application\Exceptions\User\UserNotFound;
use App\Infrastructure\Exceptions\ApiException;
use App\Infrastructure\Http\Controllers\Controller;
use App\Infrastructure\Http\Requests\User\ChangeUserAvatarRequest;
use App\Infrastructure\Http\Requests\User\ChangeUserDataRequest;
use App\Infrastructure\Http\Requests\User\ChangeUserPasswordRequest;
use App\Infrastructure\Http\Requests\User\GetUsersRequest;
use App\Infrastructure\Http\Resources\User\UserCursorResource;
use App\Infrastructure\Http\Resources\User\UserResource;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use App\Utils\Mappers\In\User\ChangeUserAvatarDtoMapper;
use App\Utils\Mappers\In\User\ChangeUserDataDtoMapper;
use App\Utils\Mappers\In\User\ChangeUserPasswordDtoMapper;
use App\Utils\Mappers\In\User\GetUsersDtoMapper;

class UserController extends Controller
{

    public function __construct(
        private readonly IUserService $userService
    ) {}

    /**
     * @param GetUsersRequest $getUsersRequest
     * @return UserCursorResource
     */
    public function getUsers(GetUsersRequest $getUsersRequest): UserCursorResource
    {
        $getUsersDto = GetUsersDtoMapper::fromRequest($getUsersRequest);
        return UserCursorResource::make(
            $this->userService->getUsers($getUsersDto)
        );
    }

    /**
     * @param int $userId
     * @return UserResource
     * @throws ApiException
     */
    public function getUser(int $userId): UserResource
    {
        try {
            return UserResource::make(
                $this->userService->getUserById($userId)
            );
        } catch (UserNotFound $e) {
            throw new ApiException($e->getMessage(), $e->getCode());
        }
    }

    /**
     * @param ChangeUserDataRequest $changeUserDataRequest
     * @return UserResource
     * @throws ApiException
     */
    public function changeData(ChangeUserDataRequest $changeUserDataRequest): UserResource
    {
        try {
            $changeUserDataDto = ChangeUserDataDtoMapper::fromRequest($changeUserDataRequest);
            $this->userService->changeData($changeUserDataDto);
            return UserResource::make(
                $this->userService->changeData($changeUserDataDto)
            );
        } catch (UserNotFound $e) {
            throw new ApiException($e->getMessage(), $e->getCode());
        }
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
     * @throws ApiException
     */
    public function changeAvatar(ChangeUserAvatarRequest $changeUserAvatarRequest): UserResource
    {
        try {
            $changeUserAvatarDto = ChangeUserAvatarDtoMapper::fromRequest($changeUserAvatarRequest);
            return UserResource::make(
                $this->userService->changeAvatar($changeUserAvatarDto)
            );
        } catch (UserNotFound $e) {
            throw new ApiException($e->getMessage(), $e->getCode());
        }
    }

    /**
     * @param ChangeUserPasswordRequest $changeUserPasswordRequest
     * @return UserResource
     * @throws ApiException
     */
    public function changePassword(ChangeUserPasswordRequest $changeUserPasswordRequest): UserResource
    {
        try {
            $changeUserPasswordDto = ChangeUserPasswordDtoMapper::fromRequest($changeUserPasswordRequest);
            return UserResource::make(
                $this->userService->changePassword($changeUserPasswordDto)
            );
        } catch (UserNotFound | InvalidOldPassword $e) {
            throw new ApiException($e->getMessage(), $e->getCode());
        }
    }
}
