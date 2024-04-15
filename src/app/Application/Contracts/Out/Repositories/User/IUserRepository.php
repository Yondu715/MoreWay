<?php

namespace App\Application\Contracts\Out\Repositories\User;

use App\Application\Contracts\Out\Repositories\Base\IBaseRepository;
use App\Infrastructure\Database\Models\User;
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
