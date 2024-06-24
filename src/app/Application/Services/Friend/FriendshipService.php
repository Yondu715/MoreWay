<?php

namespace App\Application\Services\Friend;

use App\Application\DTO\Collection\CursorDto;
use App\Application\DTO\In\Friend\AddFriendDto;
use App\Application\DTO\Out\Friend\FriendshipDto;
use App\Application\DTO\In\Friend\AcceptFriendDto;
use App\Application\Enums\Friend\RelationshipType;
use App\Application\DTO\In\Friend\GetUserFriendsDto;
use App\Application\DTO\In\Friend\GetFriendRequestsDto;
use App\Application\Exceptions\Friend\FriendRequestConflict;
use App\Application\Contracts\In\Services\Friend\IFriendshipService;
use App\Application\Contracts\Out\Managers\Notifier\INotifierManager;
use App\Application\Contracts\Out\Repositories\Friend\IFriendshipRepository;

class FriendshipService implements IFriendshipService
{

    public function __construct(
        private readonly IFriendshipRepository $friendRepository,
        private readonly INotifierManager $notifier
    ) {
    }


    /**
     * @param GetUserFriendsDto $getUserFriendsDto
     * @return CursorDto
     */
    public function getUserFriends(GetUserFriendsDto $getUserFriendsDto): CursorDto
    {
        $userFriendships = $this->friendRepository->getUserFriends($getUserFriendsDto);
        $friends = $userFriendships->data->map(function (FriendshipDto $friendshipDto) {
            return $friendshipDto->friend;
        });
        return new CursorDto(
            data: $friends,
            cursor: $userFriendships->cursor
        );
    }


    /**
     * @param GetFriendRequestsDto $getFriendRequestsDto
     * @return CursorDto
     */
    public function getFriendRequests(GetFriendRequestsDto $getFriendRequestsDto): CursorDto
    {
        return $this->friendRepository->getFriendRequestsByUserId($getFriendRequestsDto);
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
     * @return FriendshipDto
     * @throws FriendRequestConflict
     */
    public function addFriendRequest(AddFriendDto $addFriendDto): FriendshipDto

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
