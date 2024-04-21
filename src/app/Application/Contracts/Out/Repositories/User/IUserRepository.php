<?php

namespace App\Application\Contracts\Out\Repositories\User;

use App\Application\Contracts\Out\Repositories\Base\IBaseRepository;
use App\Application\DTO\In\User\GetUsersDto;
use App\Infrastructure\Database\Models\User;
use Illuminate\Pagination\CursorPaginator;

interface IUserRepository extends IBaseRepository
{

    /**
     * @param GetUsersDto $getUsersDto
     * @return CursorPaginator
     */
    public function getUsers(GetUsersDto $getUsersDto): CursorPaginator;
    /**
     * @param string $email
     * @return User|null
     */
    public function findByEmail(string $email): ?User;

}
