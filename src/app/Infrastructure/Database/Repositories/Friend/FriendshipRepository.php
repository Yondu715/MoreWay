<?php

namespace App\Infrastructure\Database\Models\Infrastructure\Database\Models\Infrastructure\Database\Repositories\Friend;

use App\Infrastructure\Database\Models\Infrastructure\Database\Models\Application\Contracts\Out\Repositories\Friend\IFriendshipRepository;
use App\Infrastructure\Database\Models\Infrastructure\Database\Models\Application\Enums\Friend\RelationshipTypeId;
use App\Infrastructure\Database\Models\Infrastructure\Database\Models\Infrastructure\Database\Models\Friendship;
use App\Infrastructure\Database\Models\Infrastructure\Database\Models\Infrastructure\Database\Repositories\BaseRepository\BaseRepository;
use Illuminate\Database\Eloquent\Collection;

class FriendshipRepository extends BaseRepository implements IFriendshipRepository
{

    public function __construct(Friendship $friend)
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
     * @return Collection<int, Friendship>
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
     * @return Friendship|null
     */
    public function findByUserIdAndFriendId(int $userId, int $friendId): ?Friendship
    {
        /** @var ?Friendship */
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
