<?php

namespace App\Application\Contracts\In\Services\Friend;

use App\Application\DTO\Collection\CursorDto;
use App\Application\DTO\In\Friend\AcceptFriendDto;
use App\Application\DTO\In\Friend\AddFriendDto;
use App\Application\DTO\In\Friend\GetFriendRequestsDto;
use App\Application\DTO\In\Friend\GetUserFriendsDto;
use App\Application\DTO\Out\Friend\FriendshipDto;

interface IFriendshipService
{

    /**
     * @param GetUserFriendsDto $getUserFriendsDto
     * @return CursorDto
     */
    public function getUserFriends(GetUserFriendsDto $getUserFriendsDto): CursorDto;


    /**
     * @param GetFriendRequestsDto $getFriendRequestsDto
     * @return CursorDto
     */
    public function getFriendRequests(GetFriendRequestsDto $getFriendRequestsDto): CursorDto;

    /**
     * @param int $userId
     * @param int $friendId
     * @return bool
     */
    public function deleteFriend(int $userId, int $friendId): bool;

    /**
     * @param AddFriendDto $addFriendDto
     * @return FriendshipDto
     */
    public function addFriendRequest(AddFriendDto $addFriendDto): FriendshipDto;

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
