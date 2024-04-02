<?php

namespace App\Repositories\User;

use App\Exceptions\User\UserNotFound;
use App\Repositories\User\Interfaces\IUserRepository;
use Illuminate\Database\Eloquent\Collection;
use App\Models\User;
use App\Repositories\BaseRepository\BaseRepository;

class UserRepository extends BaseRepository implements IUserRepository
{

    public function __construct(User $user)
    {
        parent::__construct($user);
    }

    public function findById(int $id): User
    {
        try {
            /** @var User $user */
            $user = parent::findById($id);
            return $user;
        } catch (\Throwable $th) {
            throw new UserNotFound();
        }
    }

    public function findByEmail(string $email): ?User
    {
        /** @var ?User */
        return $this->model->query()->firstWhere([
            'email'  => $email
        ]);
    }

    public function getByName(string $name): Collection
    {
        /** @var Collection<int,User> */
        return $this->model->query()->where('name', 'like', $name . '%')->get();
    }

}
