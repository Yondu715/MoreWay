<?php

namespace App\Application\Contracts\Out\Repositories;

use App\Infrastructure\Database\Models\Friendship;
use Illuminate\Database\Eloquent\Collection;

interface IFriendshipRepository extends IBaseRepository
{

    /**
     * @param int $userId
     * @param int $friendId
     * @return bool
     */
    public function deleteFriendship(int $userId, int $friendId): bool;

    /**
     * @param int $userId
     * @return Collection<int, Friendship>
     */
    public function getUserFriendships(int $userId): Collection;

    /**
     * @param int $userId
     * @param int $friendId
     * @return ?Friendship
     */
    public function findByUserIdAndFriendId(int $userId, int $friendId): ?Friendship;

    /**
     * @param int $userId
     * @return Collection<int, Friendship>
     */
    public function getFriendRequests(int $userId): Collection;
}
