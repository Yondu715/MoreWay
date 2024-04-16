<?php

namespace App\Infrastructure\Database\Models\Infrastructure\Database\Models\Application\Contracts\Out\Repositories\User;

use App\Infrastructure\Database\Models\Infrastructure\Database\Models\Application\Contracts\Out\Repositories\Base\IBaseRepository;
use App\Infrastructure\Database\Models\Infrastructure\Database\Models\Infrastructure\Database\Models\User;
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
