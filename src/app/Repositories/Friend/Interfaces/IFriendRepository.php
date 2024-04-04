<?php

namespace App\Repositories\Friend\Interfaces;

use App\Models\Friend;
use App\Repositories\BaseRepository\Interfaces\IBaseRepository;
use Illuminate\Database\Eloquent\Collection;

interface IFriendRepository extends IBaseRepository
{

    /**
     * @param int $userId
     * @param int $friendId
     * @return bool
     */
    public function deleteFriendship(int $userId, int $friendId): bool;

    /**
     * @param int $userId
     * @return Collection<int,Friend>
     */
    public function getUserFriendships(int $userId): Collection;

    /**
     * @param int $userId
     * @param int $friendId
     * @return ?Friend
     */
    public function findByUserIdAndFriendId(int $userId, int $friendId): ?Friend;

    /**
     * @param int $userId
     * @return Collection<int,Friend>
     */
    public function getFriendRequests(int $userId): Collection;
}
