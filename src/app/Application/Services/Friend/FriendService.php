<?php

namespace App\Application\Services\Friend;

use App\Application\Contracts\In\Services\IFriendService;
use App\Application\Contracts\Out\Notification\INotifier;
use App\Application\Contracts\Out\Repositories\IFriendRepository;
use App\Application\DTO\In\Friend\AcceptFriendDto;
use App\Application\DTO\In\Friend\AddFriendDto;
use App\Application\DTO\Out\Auth\UserDto;
use App\Application\Dto\Out\Friend\FriendshipRequestDto;
use App\Application\Enums\Friend\RelationshipTypeId;
use App\Application\Exceptions\Friend\FriendRequestConflict;
use App\Infrastructure\Database\Models\Friend;
use Illuminate\Support\Collection;

class FriendService implements IFriendService
{

    public function __construct(
        private readonly IFriendRepository $friendRepository,
        private readonly INotifier $notifier
    ) {
    }

    /**
     * @return Collection<int, UserDto>
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
            return FriendshipRequestDto::fromFriendModule($friendship);
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
     * @return FriendshipRequestDto
     * @throws FriendRequestConflict
     */
    public function addFriendRequest(AddFriendDto $addFriendDto): FriendshipRequestDto

    {
        /** @var ?Friend $request */
        $request = $this->friendRepository->findByUserIdAndFriendId($addFriendDto->userId, $addFriendDto->friendId);

        if ($request || $addFriendDto->friendId === $addFriendDto->userId) {
            throw new FriendRequestConflict();
        }

        /** @var Friend $request */
        $request = $this->friendRepository->create([
            'user_id' => $addFriendDto->userId,
            'friend_id' => $addFriendDto->friendId,
            'relationship_id' => RelationshipTypeId::REQUEST
        ]);

        $this->notifier->sendNotification($addFriendDto->friendId, FriendshipRequestDto::fromFriendModule($request));

        return FriendshipRequestDto::fromFriendModule($request);
    }

    /**
     * @param AcceptFriendDto $acceptFriendDto
     * @return void
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
