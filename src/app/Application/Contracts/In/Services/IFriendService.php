<?php

namespace App\Application\Contracts\In\Services;

use App\Application\DTO\In\Friend\AcceptFriendDto;
use App\Application\DTO\In\Friend\AddFriendDto;
use App\Application\Dto\Out\Friend\FriendshipRequestDto;
use Illuminate\Support\Collection;

interface IFriendService
{
    /**
     * @param int $userId
     * @return Collection<int, UserDto>
     */
    public function getUserFriends(int $userId): Collection;

    /**
     * @param int $userId
     * @return Collection<int, FriendshipRequestDto>
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
     * @return FriendshipRequestDto
     */
    public function addFriendRequest(AddFriendDto $addFriendDto): FriendshipRequestDto;

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
