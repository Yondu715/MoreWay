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
}
