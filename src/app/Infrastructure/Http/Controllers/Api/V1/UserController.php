<?php

namespace App\Infrastructure\Database\Models\Infrastructure\Database\Models\Infrastructure\Http\Controllers\Api\V1;

use App\Infrastructure\Database\Models\Infrastructure\Database\Models\Application\Contracts\In\Services\User\IUserService;
use App\Infrastructure\Database\Models\Infrastructure\Database\Models\Application\DTO\In\User\ChangeUserAvatarDto;
use App\Infrastructure\Database\Models\Infrastructure\Database\Models\Application\DTO\In\User\ChangeUserDataDto;
use App\Infrastructure\Database\Models\Infrastructure\Database\Models\Application\DTO\In\User\ChangeUserPasswordDto;
use App\Infrastructure\Database\Models\Infrastructure\Database\Models\Application\DTO\In\User\GetUsersDto;
use App\Infrastructure\Database\Models\Infrastructure\Database\Models\Infrastructure\Exceptions\ApiException;
use App\Infrastructure\Database\Models\Infrastructure\Database\Models\Infrastructure\Http\Controllers\Controller;
use App\Infrastructure\Database\Models\Infrastructure\Database\Models\Infrastructure\Http\Requests\User\ChangeUserAvatarRequest;
use App\Infrastructure\Database\Models\Infrastructure\Database\Models\Infrastructure\Http\Requests\User\ChangeUserDataRequest;
use App\Infrastructure\Database\Models\Infrastructure\Database\Models\Infrastructure\Http\Requests\User\ChangeUserPasswordRequest;
use App\Infrastructure\Database\Models\Infrastructure\Database\Models\Infrastructure\Http\Requests\User\GetUsersRequest;
use App\Infrastructure\Database\Models\Infrastructure\Database\Models\Infrastructure\Http\Resources\Auth\UserResource;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use Throwable;

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
     * @throws ApiException
     */
    public function getUser(int $userId): UserResource
    {
        try {
            return UserResource::make(
                $this->userService->getUserById($userId)
            );
        } catch (Throwable $th) {
            throw new ApiException($th->getMessage(), $th->getCode());
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
            $changeUserDataDto = ChangeUserDataDto::fromRequest($changeUserDataRequest);
            $this->userService->changeData($changeUserDataDto);
            return UserResource::make(
                $this->userService->changeData($changeUserDataDto)
            );
        } catch (Throwable $th) {
            throw new ApiException($th->getMessage(), $th->getCode());
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
            $changeUserAvatarDto = ChangeUserAvatarDto::fromRequest($changeUserAvatarRequest);
            return UserResource::make(
                $this->userService->changeAvatar($changeUserAvatarDto)
            );
        } catch (Throwable $th) {
            throw new ApiException($th->getMessage(), $th->getCode());
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
            $changeUserPasswordDto = ChangeUserPasswordDto::fromRequest($changeUserPasswordRequest);
            return UserResource::make(
                $this->userService->changePassword($changeUserPasswordDto)
            );
        } catch (Throwable $th) {
            throw new ApiException($th->getMessage(), $th->getCode());
        }
    }
}
