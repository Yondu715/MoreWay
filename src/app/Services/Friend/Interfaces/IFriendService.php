<?php

namespace App\Services\Friend\Interfaces;

use App\DTO\In\Friend\AcceptFriendDto;
use App\DTO\In\Friend\AddFriendDto;
use App\DTO\Out\Auth\UserDto;
use App\Models\Friend;
use App\Models\User;
use Illuminate\Support\Collection;

interface IFriendService
{
    /**
     * @param int $userId
     * @return Collection<int, User>
     */
    public function getUserFriends(int $userId): Collection;

    /**
     * @param int $userId
     * @return Collection<int, Friend>
     */
    public function getFriendRequests(int $userId): Collection;

    /**
     * @param int $userId
     * @param int $friendId
     * @return bool
     */
    public function deleteFriend(int $userId, int $friendId): bool;

    /**
     * @param AddFriendDto $addFriendDto
     * @return UserDto
     */
    public function addFriendRequest(AddFriendDto $addFriendDto): UserDto;

    /**
     * @param AcceptFriendDto $acceptFriendDto
     * @return void
     */
    public function acceptFriendRequest(AcceptFriendDto $acceptFriendDto): void;

    /**
     * @param int $requestId
     * @return bool
     */
    public function rejectFriendRequest(int $requestId): bool;

}
