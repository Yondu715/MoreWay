<?php

namespace App\Http\Controllers\Api\V1;

use App\DTO\User\ChangeUserAvatarDto;
use App\DTO\User\ChangeUserPasswordDto;
use App\Exceptions\User\InvalidOldPassword;
use App\Exceptions\User\UserNotFound;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\ChangeUserAvatarRequest;
use App\Http\Requests\User\ChangeUserDataRequest;
use App\Http\Requests\User\ChangeUserPasswordRequest;
use App\Services\User\UserService;
use Illuminate\Http\Response;
use App\DTO\User\ChangeUserDataDto;
use App\DTO\User\GetUsersDto;
use App\Http\Requests\User\GetUsersRequest;
use App\Http\Resources\Auth\UserResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class UserController extends Controller
{

    public function __construct(
        private readonly UserService $userService
    ) {
    }

    /**
     * @param Request $request
     * @return AnonymousResourceCollection
     */
    public function getUsers(GetUsersRequest $getUsersRequest): AnonymousResourceCollection
    {
        $getUsersDto = GetUsersDto::fromRequest($getUsersRequest);
        return UserResource::collection(
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
        $changeUserDataDto = ChangeUserDataDto::fromRequest($changeUserDataRequest);
        $this->userService->changeData($changeUserDataDto);
        return UserResource::make(
            $this->userService->changeData($changeUserDataDto)
        );
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
     * @return UserResource
     * @throws UserNotFound
     */
    public function changeAvatar(ChangeUserAvatarRequest $changeUserAvatarRequest): UserResource
    {
        $changeUserAvatarDto = ChangeUserAvatarDto::fromRequest($changeUserAvatarRequest);
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
        $changeUserPasswordDto = ChangeUserPasswordDto::fromRequest($changeUserPasswordRequest);
        return UserResource::make(
            $this->userService->changePassword($changeUserPasswordDto)
        );
    }
}
