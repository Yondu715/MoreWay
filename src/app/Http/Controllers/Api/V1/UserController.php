<?php

namespace App\Http\Controllers\Api\V1;

use App\Dto\User\ChangeUserAvatarDto;
use App\Dto\User\ChangeUserPasswordDto;
use App\Dto\User\FindUsersDto;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\ChangeUserAvatarRequest;
use App\Http\Requests\User\ChangeUserDataRequest;
use App\Http\Requests\User\ChangeUserPasswordRequest;
use App\Http\Requests\User\FindUsersRequest;
use App\Services\User\UserService;
use Illuminate\Http\Response;
use Src\App\Dto\User\ChangeUserDataDto;

class UserController extends Controller
{

    public function __construct(
        private readonly UserService $userService
    ) {
    }

    public function getUser(int $userId)
    {
        return $this->userService->getUserById($userId);
    }

    public function changeData(ChangeUserDataRequest $changeUserDataRequest)
    {
        $changeUserDataDto = ChangeUserDataDto::fromRequest($changeUserDataRequest);
        $this->userService->changeData($changeUserDataDto);
    }

    public function delete(int $userId): Response
    {
        $this->userService->deleteUserById($userId);
        return response()->noContent();
    }

    public function changeAvatar(ChangeUserAvatarRequest $changeUserAvatarRequest)
    {
        $changeUserAvatarDto = ChangeUserAvatarDto::fromRequest($changeUserAvatarRequest);
        $this->userService->changeAvatar($changeUserAvatarDto);
        
    }

    public function changePassword(ChangeUserPasswordRequest $changeUserPasswordRequest)
    {
        $changeUserPasswordDto = ChangeUserPasswordDto::fromRequest($changeUserPasswordRequest);
        return $this->userService->changePassword($changeUserPasswordDto);
    }

    public function findUsers(FindUsersRequest $findUsersRequest)
    {
        $findUsersDto = FindUsersDto::fromRequest($findUsersRequest);
        $this->userService->findUsersByName($findUsersDto->name);
    }
}
