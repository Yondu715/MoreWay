<?php

namespace App\Application\Contracts\Out\Repositories\User;

use App\Application\Contracts\Out\Repositories\Base\IBaseRepository;
use App\Application\DTO\In\User\GetUsersDto;
use App\Infrastructure\Database\Models\User;
use Illuminate\Support\Collection;

interface IUserRepository extends IBaseRepository
{

    /**
     * @param GetUsersDto $getUsersDto
     * @return Collection<int, User>
     */
    public function getUsers(GetUsersDto $getUsersDto): Collection;
    /**
     * @param string $email
     * @return User|null
     */
    public function findByEmail(string $email): ?User;

}
