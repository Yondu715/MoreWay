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
        $this->friendService->getUserFriends();
    }

    public function getFriendRequests(int $userId): void
    {
        $this->friendService->getFriendRequests();
    }

    public function deleteFriend(int $userId, int $friendId): void
    {
        $this->friendService->deleteFriend();
    }

    public function addFriendRequest(AddFriendRequest $addFriendRequest): void
    {
        $this->friendService->addFriendRequest();
    }

    public function acceptFriendRequest(AcceptFriendRequest $acceptFriendRequest): void
    {
        $this->friendService->acceptFriendRequest();
    }

    public function rejectFriendRequest(int $requestId): void
    {
        $this->friendService->rejectFriendRequest();
    }
}
