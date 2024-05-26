<?php

namespace App\Infrastructure\Http\Controllers\Api\V1;

use Illuminate\Http\Response;
use App\Infrastructure\Http\Controllers\Controller;
use App\Utils\Mappers\In\Friend\AddFriendDtoMapper;
use App\Utils\Mappers\In\Friend\AcceptFriendDtoMapper;
use App\Infrastructure\Http\Resources\User\UserResource;
use App\Infrastructure\Http\Requests\Friend\AddFriendRequest;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use App\Infrastructure\Http\Requests\Friend\AcceptFriendRequest;
use App\Application\Contracts\In\Services\Friend\IFriendshipService;
use App\Infrastructure\Http\Resources\Friend\FriendshipRequestResource;


class FriendController extends Controller
{

    public function __construct(
        private readonly IFriendshipService $friendService
    ) {
    }

    /**
     * @param int $userId
     * @return AnonymousResourceCollection
     */
    public function getFriends(int $userId): AnonymousResourceCollection
    {
        return UserResource::collection(
            $this->friendService->getUserFriends($userId)
        );
    }

    /**
     * @param int $userId
     * @return AnonymousResourceCollection
     */
    public function getFriendRequests(int $userId): AnonymousResourceCollection
    {
        return FriendshipRequestResource::collection(
            $this->friendService->getFriendRequests($userId)
        );
    }

    /**
     * @param int $userId
     * @param int $friendId
     * @return Response
     */
    public function deleteFriend(int $userId, int $friendId): Response
    {
        $this->friendService->deleteFriend($userId, $friendId);
        return response()->noContent();
    }

    /**
     * @param AddFriendRequest $addFriendRequest
     * @return FriendshipRequestResource
     */
    public function addFriendRequest(AddFriendRequest $addFriendRequest): FriendshipRequestResource
    {
        $addFriendDto = AddFriendDtoMapper::fromRequest($addFriendRequest);
        return FriendshipRequestResource::make(
            $this->friendService->addFriendRequest($addFriendDto)
        );
    }

    /**
     * @param AcceptFriendRequest $acceptFriendRequest
     * @return Response
     */
    public function acceptFriendRequest(AcceptFriendRequest $acceptFriendRequest): Response
    {
        $acceptFriendDto = AcceptFriendDtoMapper::fromRequest($acceptFriendRequest);
        $this->friendService->acceptFriendRequest($acceptFriendDto);
        return response()->noContent();
    }

    /**
     * @param int $requestId
     * @return Response
     */
    public function rejectFriendRequest(int $requestId): Response
    {
        $this->friendService->rejectFriendRequest($requestId);
        return response()->noContent();
    }
}
