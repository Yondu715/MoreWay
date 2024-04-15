<?php

namespace App\Infrastructure\Http\Controllers\Api\V1;

use App\Application\Contracts\In\Services\User\IUserService;
use App\Application\DTO\In\User\ChangeUserAvatarDto;
use App\Application\DTO\In\User\ChangeUserDataDto;
use App\Application\DTO\In\User\ChangeUserPasswordDto;
use App\Application\DTO\In\User\GetUsersDto;
use App\Infrastructure\Exceptions\ApiException;
use App\Infrastructure\Http\Controllers\Controller;
use App\Infrastructure\Http\Requests\User\ChangeUserAvatarRequest;
use App\Infrastructure\Http\Requests\User\ChangeUserDataRequest;
use App\Infrastructure\Http\Requests\User\ChangeUserPasswordRequest;
use App\Infrastructure\Http\Requests\User\GetUsersRequest;
use App\Infrastructure\Http\Resources\Auth\UserResource;
use Exception;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

class UserController extends Controller
{

    public function __construct(
        private readonly IUserService $userService
    ) {}

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
        try {
            return UserResource::make(
                $this->userService->getUserById($userId)
            );
        } catch (Exception $e) {
            throw new ApiException($e->getMessage(), $e->getCode());
        }

    }

    /**
     * @param ChangeUserDataRequest $changeUserDataRequest
     * @return UserResource
     * @throws Exception
     */
    public function changeData(ChangeUserDataRequest $changeUserDataRequest): UserResource
    {
        try {
            $changeUserDataDto = ChangeUserDataDto::fromRequest($changeUserDataRequest);
            $this->userService->changeData($changeUserDataDto);
            return UserResource::make(
                $this->userService->changeData($changeUserDataDto)
            );
        } catch (Exception $e) {
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
     * @throws Exception
     */
    public function changeAvatar(ChangeUserAvatarRequest $changeUserAvatarRequest): UserResource
    {
        try {
            $changeUserAvatarDto = ChangeUserAvatarDto::fromRequest($changeUserAvatarRequest);
            return UserResource::make(
                $this->userService->changeAvatar($changeUserAvatarDto)
            );
        } catch (Exception $e) {
            throw new ApiException($e->getMessage(), $e->getCode());
        }
    }

    /**
     * @param ChangeUserPasswordRequest $changeUserPasswordRequest
     * @return UserResource
     * @throws Exception
     */
    public function changePassword(ChangeUserPasswordRequest $changeUserPasswordRequest): UserResource
    {
        try {
            $changeUserPasswordDto = ChangeUserPasswordDto::fromRequest($changeUserPasswordRequest);
            return UserResource::make(
                $this->userService->changePassword($changeUserPasswordDto)
            );
        } catch (Exception $e) {
            throw new ApiException($e->getMessage(), $e->getCode());
        }
    }
}
