<?php

namespace App\Infrastructure\Http\Controllers\Api\V1;

use Illuminate\Http\Response;
use App\Infrastructure\Http\Controllers\Controller;
use App\Utils\Mappers\In\Friend\AddFriendDtoMapper;
use App\Utils\Mappers\In\Friend\AcceptFriendDtoMapper;
use App\Infrastructure\Http\Resources\User\UserResource;
use App\Utils\Mappers\In\Friend\GetUserFriendsDtoMapper;
use App\Infrastructure\Http\Requests\Friend\AddFriendRequest;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use App\Infrastructure\Http\Requests\Friend\AcceptFriendRequest;
use App\Infrastructure\Http\Resources\Friend\FriendshipResource;
use App\Infrastructure\Http\Requests\Friend\GetUserFriendsRequest;
use App\Application\Contracts\In\Services\Friend\IFriendshipService;
use App\Infrastructure\Http\Requests\Friend\GetFriendRequestsRequest;
use App\Infrastructure\Http\Resources\Friend\FriendshipCursorResource;
use App\Infrastructure\Http\Resources\User\UserCursorResource;
use App\Utils\Mappers\In\Friend\GetFriendRequestsDtoMapper;

class FriendController extends Controller
{

    public function __construct(
        private readonly IFriendshipService $friendService
    ) {
    }


    /**
     * @param GetUserFriendsRequest $getUserFriendsRequest
     * @return UserCursorResource
     */
    public function getFriends(GetUserFriendsRequest $getUserFriendsRequest): UserCursorResource
    {
        $getUserFriendsDto = GetUserFriendsDtoMapper::fromRequest($getUserFriendsRequest);
        return UserCursorResource::make(
            $this->friendService->getUserFriends($getUserFriendsDto)
        );
    }


    /**
     * @param GetFriendRequestsRequest $getFriendRequestsRequest
     * @return FriendshipCursorResource
     */
    public function getFriendRequests(GetFriendRequestsRequest $getFriendRequestsRequest): FriendshipCursorResource
    {
        $getFriendRequestsDto = GetFriendRequestsDtoMapper::fromRequest($getFriendRequestsRequest);
        return FriendshipCursorResource::make(
            $this->friendService->getFriendRequests($getFriendRequestsDto)
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
     * @return FriendshipResource
     */
    public function addFriendRequest(AddFriendRequest $addFriendRequest): FriendshipResource
    {
        $addFriendDto = AddFriendDtoMapper::fromRequest($addFriendRequest);
        return FriendshipResource::make(
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
