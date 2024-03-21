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
use App\Services\Friend\Interfaces\IFriendService;
use Illuminate\Support\Collection;

class FriendService implements IFriendService
{
    /**
     * @return Collection<int, User>
     * @throws UserNotFound
     */
    public function getUserFriends(int $userId): Collection
    {
        /** @var ?User $user */
        $user = User::query()->find($userId);
        if (!$user) {
            throw new UserNotFound();
        }
        $friends = $user->friends()->wherePivot('relationship_id', '=', RelationshipTypeId::FRIEND)->get();
        return $friends->map(function (User $friend) {
            return UserDto::fromUserModel($friend);
        });
    }

    /**
     * @param int $userId
     * @return Collection<int, Friend>
     */
    public function getFriendRequests(int $userId): Collection
    {
        $requests = Friend::query()->where([
            'friend_id' => $userId,
            'relationship_id' => RelationshipTypeId::REQUEST
        ])->with('user')->get();
        return $requests->map(function (Friend $friend) {
            return UserDto::fromFriendModel($friend);
        });
    }

    /**
     * @param int $userId
     * @param int $friendId
     * @return void
     */
    public function deleteFriend(int $userId, int $friendId): void
    {
        Friend::query()->where([
            'user_id' => $userId,
            'friend_id' => $friendId
        ])->orWhere([
            'user_id' => $friendId,
            'friend_id' => $userId
        ])->delete();
    }

    /**
     * @param AddFriendDto $addFriendDto
     * @return UserDto
     *
     * @throws FriendRequestConflict
     */
    public function addFriendRequest(AddFriendDto $addFriendDto): UserDto

    {
        /** @var ?Friend $request */
        $request = Friend::query()->firstWhere([
            'user_id' => $addFriendDto->userId,
            'friend_id' => $addFriendDto->friendId
        ]);
        if ($request) {
            throw new FriendRequestConflict();
        }

        /** @var Friend $request */
        $request = Friend::query()->create([
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
        /** @var ?Friend $request */
        $request = Friend::query()->find($acceptFriendDto->requestId);
        if (!$request) {
            throw new FriendRequestNotFound();
        }
        $request->update([
            'relationship_id' => RelationshipTypeId::FRIEND
        ]);
        Friend::query()->create([
            'user_id' => $request->friend_id,
            'friend_id' => $request->user_id,
            'relationship_id' => RelationshipTypeId::FRIEND
        ]);
    }

    /**
     * @param int $requestId
     * @return bool|null
     */
    public function rejectFriendRequest(int $requestId): ?bool
    {
        return Friend::query()->find($requestId)->delete();
    }
}
