<?php

namespace App\Repositories\User\Interfaces;

use App\Models\User;
use App\Repositories\BaseRepository\Interfaces\IBaseRepository;
use Illuminate\Database\Eloquent\Collection;

interface IUserRepository extends IBaseRepository
{

    /**
     * @param string $email
     * @return User|null
     */
    public function findByEmail(string $email): ?User;

    /**
     * @param string $name
     * @return Collection<int,User>
     */
    public function getByName(string $name): Collection;
}
