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

    public function getFriends(int $userId)
    {
    }

    public function getFriendRequests(int $userId)
    {
    }

    public function deleteFriend(int $userId, int $friendId)
    {
    }

    public function addFriendRequest(AddFriendRequest $addFriendRequest)
    {
    }

    public function acceptFriendRequest(AcceptFriendRequest $acceptFriendRequest)
    {
    }

    public function rejectFriendRequest(int $requestId)
    {
    }
}
