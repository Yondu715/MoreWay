<?php

namespace App\Application\Contracts\Out\Repositories\Friend;

use App\Application\DTO\Out\Friend\FriendshipRequestDto;
use Illuminate\Support\Collection;

interface IFriendshipRepository
{

    /**
     * @param int $id
     * @return FriendshipRequestDto
     */
    public function findById(int $id): FriendshipRequestDto;

    /**
     * @param int $id
     * @return bool
     */
    public function deleteById(int $id): bool;

    /**
     * @param int $id
     * @param array $data
     * @return FriendshipRequestDto
     */
    public function create(array $data): FriendshipRequestDto;

    /**
     * @param int $id
     * @param array $data
     * @return FriendshipRequestDto
     */
    public function update(int $id, array $data): FriendshipRequestDto;

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
    public function getUserFriendships(int $userId): Collection;

    /**
     * @param int $userId
     * @param int $friendId
     * @return ?FriendshipRequestDto
     */
    public function findByUserIdAndFriendId(int $userId, int $friendId): ?FriendshipRequestDto;

    /**
     * @param int $userId
     * @return Collection<int, FriendshipRequestDto>
     */
    public function getFriendRequests(int $userId): Collection;
}
