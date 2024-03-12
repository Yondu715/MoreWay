<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Friend\AcceptFriendRequest;
use App\Http\Requests\Friend\AddFriendRequest;
use App\Services\Friend\FriendService;

class FriendController extends Controller
{

    public function __construct(
        private readonly FriendService $friendService
    ) {
    }

    public function getFriends(int $userId): void
    {
    }

    public function getFriendRequests(int $userId): void
    {
    }

    public function deleteFriend(int $userId, int $friendId): void
    {
    }

    public function addFriendRequest(AddFriendRequest $addFriendRequest): void
    {
    }

    public function acceptFriendRequest(AcceptFriendRequest $acceptFriendRequest): void
    {
    }

    public function rejectFriendRequest(int $requestId): void
    {
    }
}
