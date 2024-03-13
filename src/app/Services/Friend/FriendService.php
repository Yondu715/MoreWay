<?php

namespace App\Services\Friend;

use App\DTO\Friend\AcceptFriendDto;
use App\DTO\Friend\AddFriendDto;
use App\Enums\Friend\RelationshipTypeId;
use App\Exceptions\User\UserNotFound;
use App\Models\Friend;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

class FriendService
{
    /**
     * @param int $userId
     * @return Collection<int, User>
     */
    public function getUserFriends(int $userId): Collection
    {
        /** @var ?User */
        $user = User::query()->find($userId);
        if (!$user) {
            throw new UserNotFound();
        }
        return $user->friends()->wherePivot('relationship_id', '=', RelationshipTypeId::FRIEND)->get();
    }

    public function getFriendRequests(): void
    {
    }

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

    public function addFriendRequest(AddFriendDto $addFriendDto): void
    {
    }

    public function acceptFriendRequest(AcceptFriendDto $acceptFriendDto): void
    {
    }

    public function rejectFriendRequest(int $requestId): ?bool
    {
        return Friend::query()->find($requestId)->delete();
    }
}
