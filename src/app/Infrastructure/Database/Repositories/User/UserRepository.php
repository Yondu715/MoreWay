<?php

namespace App\Infrastructure\Database\Repositories\User;

use App\Application\Contracts\Out\Repositories\IUserRepository;
use App\Application\Exceptions\User\UserNotFound;
use App\Infrastructure\Database\Models\User;
use App\Infrastructure\Database\Repositories\BaseRepository\BaseRepository;
use Illuminate\Database\Eloquent\Collection;
use Throwable;

class UserRepository extends BaseRepository implements IUserRepository
{

    public function __construct(User $user)
    {
        parent::__construct($user);
    }

    /**
     * @param int $id
     * @return User
     * @throws UserNotFound
     */
    public function findById(int $id): User
    {
        try {
            /** @var User $user */
            $user = parent::findById($id);
            return $user;
        } catch (Throwable $th) {
            throw new UserNotFound();
        }
    }

    /**
     * @param string $email
     * @return User|null
     */
    public function findByEmail(string $email): ?User
    {
        /** @var ?User */
        return $this->model->query()->firstWhere([
            'email'  => $email
        ]);
    }

    /**
     * @param string $name
     * @return Collection<int,User>
     */
    public function getByName(string $name): Collection
    {
        /** @var Collection<int,User> */
        return $this->model->query()->where('name', 'like', $name . '%')->get();
    }

}
