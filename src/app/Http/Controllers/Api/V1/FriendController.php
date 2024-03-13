<?php

namespace App\Http\Controllers\Api\V1;

use App\DTO\Friend\AcceptFriendDto;
use App\DTO\Friend\AddFriendDto;
use App\Http\Controllers\Controller;
use App\Http\Requests\Friend\AcceptFriendRequest;
use App\Http\Requests\Friend\AddFriendRequest;
use App\Http\Resources\Auth\UserResource;
use App\Services\Friend\FriendService;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

class FriendController extends Controller
{

    public function __construct(
        private readonly FriendService $friendService
    ) {
    }

    public function getFriends(int $userId): AnonymousResourceCollection
    {
        return UserResource::collection(
            $this->friendService->getUserFriends($userId)
        );
    }

    public function getFriendRequests(int $userId): void
    {
        $this->friendService->getFriendRequests();
    }

    public function deleteFriend(int $userId, int $friendId): Response
    {
        $this->friendService->deleteFriend($userId, $friendId);
        return response()->noContent();
    }

    public function addFriendRequest(AddFriendRequest $addFriendRequest): void
    {
        $addFriendDto = AddFriendDto::fromRequest($addFriendRequest);
        $this->friendService->addFriendRequest($addFriendDto);
    }

    public function acceptFriendRequest(AcceptFriendRequest $acceptFriendRequest): void
    {
        $acceptFriendDto = AcceptFriendDto::fromRequest($acceptFriendRequest);
        $this->friendService->acceptFriendRequest($acceptFriendDto);
    }

    public function rejectFriendRequest(int $requestId): Response
    {
        $this->friendService->rejectFriendRequest($requestId);
        return response()->noContent();
    }
}
