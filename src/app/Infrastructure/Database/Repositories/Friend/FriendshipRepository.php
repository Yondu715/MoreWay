<?php

namespace App\Infrastructure\Database\Repositories\Friend;

use App\Application\Contracts\Out\Repositories\Friend\IFriendshipRepository;
use App\Application\DTO\Out\Friend\FriendshipDto;
use App\Application\Enums\Friend\RelationshipType;
use App\Application\Exceptions\Friend\FriendRequestNotFound;
use App\Infrastructure\Database\Models\Friendship;
use App\Utils\Mappers\Out\User\UserDtoMapper;
use Illuminate\Database\Eloquent\Model;
use App\Utils\Mappers\Out\Friend\FriendshipDtoMapper;
use Illuminate\Support\Collection;
use Throwable;

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
     * @throws FriendRequestNotFound
     */
    public function findById(int $id): FriendshipDto
    {
        try {
            /** @var Friendship $friendship */
            $friendship = $this->model->query()->findOrFail($id);
            return FriendshipDtoMapper::fromFriendshipModel($friendship);
        } catch (Throwable) {
            throw new FriendRequestNotFound();
        }
    }

    /**
     * @param int $id
     * @return bool
     */
    public function deleteById(int $id): bool
    {
        return $this->model->query()->where([
            'id' => $id
        ])->delete();
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
     * @param int $userId
     * @return Collection<int, FriendshipDto>
     */
    public function getUserFriendships(int $userId): Collection
    {
        $friendships = $this->model->query()->where([
            'user_id' => $userId,
            'relationship_id' => RelationshipType::FRIEND
        ])->with('friend')->get();

        return $friendships->map(function (Friendship $friendship) {
            return UserDtoMapper::fromUserModel($friendship->friend);
        });
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
     * @param int $userId
     * @return Collection<int, FriendshipDto>
     */
    public function getFriendRequests(int $userId): Collection
    {
        $friendRequests = $this->model->query()->where([
            'friend_id' => $userId,
            'relationship_id' => RelationshipType::REQUEST
        ])->with('user')->get();

        return $friendRequests->map(function (Friendship $friendship) {
            return FriendshipDtoMapper::fromFriendshipModel($friendship);
        });
    }
}
