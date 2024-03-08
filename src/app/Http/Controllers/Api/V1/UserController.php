<?php

namespace App\Http\Controllers\Api\V1;

use App\Dto\User\ChangeUserAvatarDto;
use App\Dto\User\ChangeUserPasswordDto;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\ChangeUserAvatarRequest;
use App\Http\Requests\User\ChangeUserPasswordRequest;
use App\Services\User\UserService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

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

    public function changeData()
    {
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

    public function findUsers(Request $request)
    {
    }
}
