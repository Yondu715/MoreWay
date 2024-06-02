<?php

namespace App\Application\Contracts\Out\Repositories\Friend;

use App\Application\DTO\Out\Friend\FriendshipDto;
use Illuminate\Support\Collection;

interface IFriendshipRepository
{

    /**
     * @param int $id
     * @return FriendshipDto
     */
    public function findById(int $id): FriendshipDto;

    /**
     * @param int $id
     * @return bool
     */
    public function deleteById(int $id): bool;

    /**
     * @param int $id
     * @param array $data
     * @return FriendshipDto
     */
    public function create(array $data): FriendshipDto;

    /**
     * @param int $id
     * @param array $data
     * @return FriendshipDto
     */
    public function update(int $id, array $data): FriendshipDto;

    /**
     * @param int $userId
     * @param int $friendId
     * @return bool
     */
    public function deleteFriendship(int $userId, int $friendId): bool;

    /**
     * @param int $userId
     * @return Collection<int, UserDto>
     */
    public function getUserFriends(int $userId): Collection;

    /**
     * @param int $userId
     * @param int $friendId
     * @return ?FriendshipDto
     */
    public function findByUserIdAndFriendId(int $userId, int $friendId): ?FriendshipDto;

    /**
     * @param int $userId
     * @return Collection<int, FriendshipDto>
     */
    public function getFriendRequestsByUserId(int $userId): Collection;
}
