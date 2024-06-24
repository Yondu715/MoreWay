<?php

namespace App\Infrastructure\Database\Repositories\Friend;

use Throwable;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;
use App\Utils\Mappers\Out\User\UserDtoMapper;
use App\Application\DTO\Out\Friend\FriendshipDto;
use App\Application\Enums\Friend\RelationshipType;
use App\Infrastructure\Database\Models\Friendship;
use App\Utils\Mappers\Out\Friend\FriendshipDtoMapper;
use App\Application\Exceptions\Friend\FriendshipNotFound;
use App\Application\Contracts\Out\Repositories\Friend\IFriendshipRepository;
use App\Application\DTO\Collection\CursorDto;
use App\Application\DTO\In\Friend\GetFriendRequestsDto;
use App\Application\DTO\In\Friend\GetUserFriendsDto;
use App\Application\DTO\Out\User\UserDto;
use App\Utils\Mappers\Collection\CursorDtoMapper;

class FriendshipRepository implements IFriendshipRepository
{

    private readonly Model $model;

    public function __construct(Friendship $friend)
    {
        $this->model = $friend;
    }

    /**
     * @param int $id
     * @return FriendshipDto
     * @throws FriendshipNotFound
     */
    public function findById(int $id): FriendshipDto
    {
        try {
            /** @var Friendship $friendship */
            $friendship = $this->model->query()->findOrFail($id);
            return FriendshipDtoMapper::fromFriendshipModel($friendship);
        } catch (Throwable) {
            throw new FriendshipNotFound();
        }
    }

    /**
     * @param int $id
     * @return bool
     */
    public function deleteById(int $id): bool
    {
        return $this->model->query()->where('id', $id)->delete();
    }

    /**
     * @param array $data
     * @return FriendshipDto
     */
    public function create(array $data): FriendshipDto
    {
        /** @var Friendship $friendship */
        $friendship = $this->model->query()->create($data);
        return FriendshipDtoMapper::fromFriendshipModel($friendship);
    }

    /**
     * @param int $id
     * @param array $data
     * @return FriendshipDto
     */
    public function update(int $id, array $data): FriendshipDto
    {
        /** @var Friendship $friendship */
        $friendship = $this->model->query()->findOrFail($id);
        $friendship->update($data);
        return FriendshipDtoMapper::fromFriendshipModel($friendship->refresh());
    }

    /**
     * @param int $userId
     * @param int $friendId
     * @return bool
     */
    public function deleteFriendship(int $userId, int $friendId): bool
    {
        return $this->model->query()->where(function ($query) use ($userId, $friendId) {
            $query->where([
                'user_id' => $userId,
                'friend_id' => $friendId
            ])->orWhere([
                'user_id' => $friendId,
                'friend_id' => $userId
            ]);
        })->delete();
    }


    /**
     * @param GetUserFriendsDto $getUserFriendsDto
     * @return CursorDto
     */
    public function getUserFriends(GetUserFriendsDto $getUserFriendsDto): CursorDto
    {
        $friendships = $this->model->query()->where([
            'user_id' => $getUserFriendsDto->userId,
            'relationship_id' => RelationshipType::FRIEND
        ])->with(['friend'])->cursorPaginate(perPage: $getUserFriendsDto->limit, cursor: $getUserFriendsDto->cursor);
        
        return FriendshipDtoMapper::fromPaginator($friendships);
    }

    /**
     * @param int $userId
     * @param int $friendId
     * @return FriendshipDto|null
     */
    public function findByUserIdAndFriendId(int $userId, int $friendId): ?FriendshipDto
    {
        /** @var ?Friendship $friendship1 */
        $friendship1 = $this->model->query()->where([
            'user_id' => $userId,
            'friend_id' => $friendId
        ])->first();

        /** @var ?Friendship $friendship2 */
        $friendship2 = $this->model->query()->where([
            'user_id' => $friendId,
            'friend_id' => $userId
        ])->first();
        
        $friendship = $friendship1 ?: $friendship2;
        return $friendship ? FriendshipDtoMapper::fromFriendshipModel($friendship) : null;
    }


    /**
     * @param GetFriendRequestsDto $getFriendRequestsDto
     * @return CursorDto
     */
    public function getFriendRequestsByUserId(GetFriendRequestsDto $getFriendRequestsDto): CursorDto
    {
        $friendRequests = $this->model->query()->where([
            'friend_id' => $getFriendRequestsDto->userId,
            'relationship_id' => RelationshipType::REQUEST
        ])->with(['user', 'friend'])->cursorPaginate(perPage: $getFriendRequestsDto->limit, cursor: $getFriendRequestsDto->cursor);

        return FriendshipDtoMapper::fromPaginator($friendRequests);
    }
}
