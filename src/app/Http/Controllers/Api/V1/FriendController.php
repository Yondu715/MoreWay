<?php

namespace App\Http\Controllers\Api\V1;

use App\DTO\In\Friend\AcceptFriendDto;
use App\DTO\In\Friend\AddFriendDto;
use App\Http\Controllers\Controller;
use App\Http\Requests\Friend\AcceptFriendRequest;
use App\Http\Requests\Friend\AddFriendRequest;
use App\Http\Resources\Auth\UserResource;
use App\Services\Friend\Interfaces\IFriendService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

class FriendController extends Controller
{

    public function __construct(
        private readonly IFriendService $friendService
    ) {
    }

    public function getFriends(int $userId): AnonymousResourceCollection
    {
        return UserResource::collection(
            $this->friendService->getUserFriends($userId)
        );
    }

    public function getFriendRequests(int $userId): JsonResponse
    {
        return response()->json([
            $this->friendService->getFriendRequests($userId)
        ]);
    }

    public function deleteFriend(int $userId, int $friendId): Response
    {
        $this->friendService->deleteFriend($userId, $friendId);
        return response()->noContent();
    }

    public function addFriendRequest(AddFriendRequest $addFriendRequest): UserResource
    {
        $addFriendDto = AddFriendDto::fromRequest($addFriendRequest);
        return UserResource::make(
            $this->friendService->addFriendRequest($addFriendDto)
        );
    }

    public function acceptFriendRequest(AcceptFriendRequest $acceptFriendRequest): Response
    {
        $acceptFriendDto = AcceptFriendDto::fromRequest($acceptFriendRequest);
        $this->friendService->acceptFriendRequest($acceptFriendDto);
        return response()->noContent();
    }

    public function rejectFriendRequest(int $requestId): Response
    {
        $this->friendService->rejectFriendRequest($requestId);
        return response()->noContent();
    }
}
