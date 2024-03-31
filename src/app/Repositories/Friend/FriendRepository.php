<?php

namespace App\Repositories\Friend;

use App\Models\Friend;
use App\Repositories\BaseRepository\BaseRepository;
use App\Repositories\Friend\Interfaces\IFriendRepository;

class FriendRepository extends BaseRepository implements IFriendRepository
{

    public function __construct(Friend $friend)
    {
        parent::__construct($friend);
    }

    public function deleteFriendship(int $userId, int $friendId): ?bool
    {
        return $this->model->query()->where([
            'user_id' => $userId,
            'friend_id' => $friendId
        ])->orWhere([
            'user_id' => $friendId,
            'friend_id' => $userId
        ])->delete();
    }
}
