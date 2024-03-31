<?php

namespace App\Repositories\Friend\Interfaces;

use App\Repositories\BaseRepository\Interfaces\IBaseRepository;

interface IFriendRepository extends IBaseRepository
{

    /**
     * @param int $userId
     * @param int $friendId
     * @return bool|null
     */
    public function deleteFriendship(int $userId, int $friendId): ?bool;
}