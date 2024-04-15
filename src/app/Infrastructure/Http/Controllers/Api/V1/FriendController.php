<?php

namespace App\Infrastructure\Http\Controllers\Api\V1;

use App\Application\Contracts\In\Services\Friend\IFriendshipService;
use App\Application\DTO\In\Friend\AcceptFriendDto;
use App\Application\DTO\In\Friend\AddFriendDto;
use App\Infrastructure\Exceptions\ApiException;
use App\Infrastructure\Http\Controllers\Controller;
use App\Infrastructure\Http\Requests\Friend\AcceptFriendRequest;
use App\Infrastructure\Http\Requests\Friend\AddFriendRequest;
use App\Infrastructure\Http\Resources\Auth\UserResource;
use App\Infrastructure\Http\Resources\Friend\FriendshipRequestResource;
use Exception;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

class FriendController extends Controller
{

    public function __construct(
        private readonly IFriendshipService $friendService
    ) {}

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
     * @throws ApiException
     */
    public function addFriendRequest(AddFriendRequest $addFriendRequest): FriendshipRequestResource
    {
        try {
            $addFriendDto = AddFriendDto::fromRequest($addFriendRequest);
            return FriendshipRequestResource::make(
                $this->friendService->addFriendRequest($addFriendDto)
            );
        } catch (Exception $e) {
            throw new ApiException($e->getMessage(), $e->getCode());
        }

    }

    /**
     * @param AcceptFriendRequest $acceptFriendRequest
     * @return Response
     * @throws ApiException
     */
    public function acceptFriendRequest(AcceptFriendRequest $acceptFriendRequest): Response
    {
        try {
            $acceptFriendDto = AcceptFriendDto::fromRequest($acceptFriendRequest);
            $this->friendService->acceptFriendRequest($acceptFriendDto);
            return response()->noContent();
        } catch (Exception $e) {
            throw new ApiException($e->getMessage(), $e->getCode());
        }
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
