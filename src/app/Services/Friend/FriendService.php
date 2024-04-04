<?php

namespace App\Services\Friend;

use App\DTO\In\Friend\AcceptFriendDto;
use App\DTO\In\Friend\AddFriendDto;
use App\DTO\Out\Auth\UserDto;
use App\Enums\Friend\RelationshipTypeId;
use App\Exceptions\Friend\FriendRequestConflict;
use App\Exceptions\Friend\FriendRequestNotFound;
use App\Exceptions\User\UserNotFound;
use App\Models\Friend;
use App\Models\User;
use App\Repositories\Friend\Interfaces\IFriendRepository;
use App\Services\Friend\Interfaces\IFriendService;
use Illuminate\Support\Collection;

class FriendService implements IFriendService
{

    public function __construct(
        private readonly IFriendRepository $friendRepository
    ) {
    }

    /**
     * @return Collection<int, UserDto>
     * @throws UserNotFound
     */
    public function getUserFriends(int $userId): Collection
    {
        $friendships = $this->friendRepository->getUserFriendships($userId);
        return $friendships->map(function (Friend $friendship) {
            return UserDto::fromUserModel($friendship->friend);
        });
    }

    /**
     * @param int $userId
     * @return Collection<int, UserDto>
     */
    public function getFriendRequests(int $userId): Collection
    {
        $friendships = $this->friendRepository->getFriendRequests($userId);
        return $friendships->map(function (Friend $friendship) {
            return UserDto::fromUserModel($friendship->user);
        });
    }

    /**
     * @param int $userId
     * @param int $friendId
     * @return bool
     */
    public function deleteFriend(int $userId, int $friendId): bool
    {
        return $this->friendRepository->deleteFriendship($userId, $friendId);
    }

    /**
     * @param AddFriendDto $addFriendDto
     * @return UserDto
     * @throws FriendRequestConflict
     */
    public function addFriendRequest(AddFriendDto $addFriendDto): UserDto

    {
        /** @var ?Friend $request */
        $request = $this->friendRepository->findByUserIdAndFriendId($addFriendDto->userId, $addFriendDto->friendId);

        if ($request || $addFriendDto->friendId === $addFriendDto->userId) {
            throw new FriendRequestConflict();
        }

        $request = $this->friendRepository->create([
            'user_id' => $addFriendDto->userId,
            'friend_id' => $addFriendDto->friendId,
            'relationship_id' => RelationshipTypeId::REQUEST
        ]);
        return UserDto::fromUserModel($request->friend);
    }

    /**
     * @param AcceptFriendDto $acceptFriendDto
     * @return void
     * @throws FriendRequestNotFound
     */
    public function acceptFriendRequest(AcceptFriendDto $acceptFriendDto): void
    {
        /** @var Friend $friendship */
        $friendship = $this->friendRepository->findById($acceptFriendDto->requestId);


        $this->friendRepository->update($friendship->id, [
            'relationship_id' => RelationshipTypeId::FRIEND
        ]);

        $this->friendRepository->create([
            'user_id' => $friendship->friend_id,
            'friend_id' => $friendship->user_id,
            'relationship_id' => RelationshipTypeId::FRIEND
        ]);
    }

    /**
     * @param int $requestId
     * @return bool
     */
    public function rejectFriendRequest(int $requestId): bool
    {
        return $this->friendRepository->deleteById($requestId);
    }
}
