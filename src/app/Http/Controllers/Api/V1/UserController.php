<?php

namespace App\Http\Controllers\Api\V1;

use App\DTO\In\User\ChangeUserAvatarDto;
use App\DTO\In\User\ChangeUserDataDto;
use App\DTO\In\User\ChangeUserPasswordDto;
use App\DTO\In\User\GetUsersDto;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\ChangeUserAvatarRequest;
use App\Http\Requests\User\ChangeUserDataRequest;
use App\Http\Requests\User\ChangeUserPasswordRequest;
use App\Http\Requests\User\GetUsersRequest;
use App\Http\Resources\Auth\UserResource;
use App\Services\User\Interfaces\IUserService;
use Exception;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

class UserController extends Controller
{

    public function __construct(
        private readonly IUserService $userService
    ) {
    }

    /**
     * @param GetUsersRequest $getUsersRequest
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
     * @throws Exception
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
     * @throws Exception
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
     * @throws Exception
     */
    public function delete(int $userId): Response
    {
        $this->userService->deleteUserById($userId);
        return response()->noContent();
    }

    /**
     * @param ChangeUserAvatarRequest $changeUserAvatarRequest
     * @return UserResource
     * @throws Exception
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
     * @throws Exception
     */
    public function changePassword(ChangeUserPasswordRequest $changeUserPasswordRequest): UserResource
    {
        $changeUserPasswordDto = ChangeUserPasswordDto::fromRequest($changeUserPasswordRequest);
        return UserResource::make(
            $this->userService->changePassword($changeUserPasswordDto)
        );
    }
}
