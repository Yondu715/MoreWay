<?php

namespace App\Infrastructure\Database\Repositories\Friend;

use App\Application\Contracts\Out\Repositories\Friend\IFriendshipRepository;
use App\Application\DTO\Out\Friend\FriendshipRequestDto;
use App\Application\Enums\Friend\RelationshipType;
use App\Infrastructure\Database\Models\Friendship;
use App\Utils\Mappers\Out\Auth\UserDtoMapper;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use App\Utils\Mappers\Out\Friend\FriendshipRequestDtoMapper;

class FriendshipRepository implements IFriendshipRepository
{

    private Model $model;

    public function __construct(Friendship $friend)
    {
        $this->model = $friend;
    }

    /**
     * @param int $id
     * @return FriendshipRequestDto
     */
    public function findById(int $id): FriendshipRequestDto
    {
        try {
            return FriendshipRequestDtoMapper::fromFriendshipModel($this->model->query()->findOrFail($id));
        } catch (\Throwable $th) {
            dd('abobaa');
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
     * @return FriendshipRequestDto
     */
    public function create(array $data): FriendshipRequestDto
    {
        $friendship = $this->model->query()->create($data);
        return FriendshipRequestDtoMapper::fromFriendshipModel($friendship);
    }

    /**
     * @param int $id
     * @param array $data
     * @return FriendshipRequestDto
     */
    public function update(int $id, array $data): FriendshipRequestDto
    {
        $friendship = $this->model->query()->findOrFail($id);
        $friendship->update($data);
        return FriendshipRequestDtoMapper::fromFriendshipModel($friendship->refresh());
    }

    /**
     * @param int $userId
     * @param int $friendId
     * @return bool
     */
    public function deleteFriendship(int $userId, int $friendId): bool
    {
        return $this->model->query()->where([
            'user_id' => $userId,
            'friend_id' => $friendId
        ])->orWhere([
            'user_id' => $friendId,
            'friend_id' => $userId
        ])->delete();
    }

    /**
     * @param int $userId
     * @return Collection<int, FriendshipRequestDto>
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
     * @return FriendshipRequestDto|null
     */
    public function findByUserIdAndFriendId(int $userId, int $friendId): ?FriendshipRequestDto
    {
        /** @var ?Friendship */
        $friendship = $this->model->query()->firstWhere([
            'user_id' => $userId,
            'friend_id' => $friendId
        ]);

        return $friendship ? FriendshipRequestDtoMapper::fromFriendshipModel($friendship) : null;
    }

    /**
     * @param int $userId
     * @return Collection<int, FriendshipRequestDto>
     */
    public function getFriendRequests(int $userId): Collection
    {
        $friendRequests = $this->model->query()->where([
            'friend_id' => $userId,
            'relationship_id' => RelationshipType::REQUEST
        ])->with('user')->get();

        return $friendRequests->map(function (Friendship $friendship) {
            return FriendshipRequestDtoMapper::fromFriendshipModel($friendship);
        });
    }
}
