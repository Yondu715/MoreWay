<?php

namespace App\Application\Services\Friend;

use App\Application\Contracts\In\Services\Friend\IFriendshipService;
use App\Application\Contracts\Out\Managers\Notifier\INotifierManager;
use App\Application\Contracts\Out\Repositories\Friend\IFriendshipRepository;
use App\Application\DTO\In\Friend\AcceptFriendDto;
use App\Application\DTO\In\Friend\AddFriendDto;
use App\Application\DTO\Out\Friend\FriendshipRequestDto;
use App\Application\DTO\Out\User\UserDto;
use App\Application\Enums\Friend\RelationshipType;
use App\Application\Exceptions\Friend\FriendRequestConflict;
use Illuminate\Support\Collection;


class FriendshipService implements IFriendshipService
{

    public function __construct(
        private readonly IFriendshipRepository $friendRepository,
        private readonly INotifierManager $notifier
    ) {
    }

    /**
     * @return Collection<int, UserDto>
     */
    public function getUserFriends(int $userId): Collection
    {
        return $this->friendRepository->getUserFriendships($userId);
    }

    /**
     * @param int $userId
     * @return Collection<int, FriendshipRequestDto>
     */
    public function getFriendRequests(int $userId): Collection
    {
        return $this->friendRepository->getFriendRequests($userId);
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
        $request = $this->friendRepository->findByUserIdAndFriendId($addFriendDto->userId, $addFriendDto->friendId);

        if ($request || $addFriendDto->friendId === $addFriendDto->userId) {
            throw new FriendRequestConflict();
        }

        $request = $this->friendRepository->create([
            'user_id' => $addFriendDto->userId,
            'friend_id' => $addFriendDto->friendId,
            'relationship_id' => RelationshipType::REQUEST
        ]);

        $this->notifier->sendNotification($addFriendDto->friendId, $request);

        return $request;
    }

    /**
     * @param AcceptFriendDto $acceptFriendDto
     * @return void
     */
    public function acceptFriendRequest(AcceptFriendDto $acceptFriendDto): void
    {
        $friendship = $this->friendRepository->findById($acceptFriendDto->requestId);


        $this->friendRepository->update($friendship->id, [
            'relationship_id' => RelationshipType::FRIEND
        ]);

        $this->friendRepository->create([
            'user_id' => $friendship->friendId,
            'friend_id' => $friendship->userId,
            'relationship_id' => RelationshipType::FRIEND
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
