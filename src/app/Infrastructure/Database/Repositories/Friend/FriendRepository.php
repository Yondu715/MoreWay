<?php

namespace App\Infrastructure\Database\Repositories\Friend;

use App\Application\Contracts\Out\Repositories\IFriendRepository;
use App\Application\Enums\Friend\RelationshipTypeId;
use App\Infrastructure\Database\Models\Friend;
use App\Infrastructure\Database\Repositories\BaseRepository\BaseRepository;
use Illuminate\Database\Eloquent\Collection;

class FriendRepository extends BaseRepository implements IFriendRepository
{

    public function __construct(Friend $friend)
    {
        parent::__construct($friend);
    }

    /**
     * @param int $userId
     * @param int $friendId
     * @return bool
     */
    public function deleteFriendship(int $userId, int $friendId): bool
    {
        return $this->model->query()->where([
            'user_id' => $userId,
            'friend_id' => $friendId
        ])->orWhere([
            'user_id' => $friendId,
            'friend_id' => $userId
        ])->delete();
    }

    /**
     * @param int $userId
     * @return Collection<int,Friend>
     */
    public function getUserFriendships(int $userId): Collection
    {
        return $this->model->query()->where([
            'user_id' => $userId,
            'relationship_id' => RelationshipTypeId::FRIEND
        ])->with('friend')->get();
    }

    /**
     * @param int $userId
     * @param int $friendId
     * @return Friend|null
     */
    public function findByUserIdAndFriendId(int $userId, int $friendId): ?Friend
    {
        /** @var ?Friend */
        return $this->model->query()->firstWhere([
            'user_id' => $userId,
            'friend_id' => $friendId
        ]);
    }

    /**
     * @param int $userId
     * @return Collection
     */
    public function getFriendRequests(int $userId): Collection
    {
        return $this->model->query()->where([
            'friend_id' => $userId,
            'relationship_id' => RelationshipTypeId::REQUEST
        ])->with('user')->get();
    }
}
