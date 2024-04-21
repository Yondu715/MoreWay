<?php

namespace App\Infrastructure\Database\Repositories\User;

use App\Application\Contracts\Out\Repositories\User\IUserRepository;
use App\Application\DTO\In\User\GetUsersDto;
use App\Application\Enums\Role\RoleType;
use App\Application\Exceptions\User\UserNotFound;
use App\Infrastructure\Database\Models\Filters\User\UserFilterFactory;
use App\Infrastructure\Database\Models\User;
use App\Infrastructure\Database\Repositories\BaseRepository\BaseRepository;
use Illuminate\Pagination\CursorPaginator;
use Throwable;

class UserRepository extends BaseRepository implements IUserRepository
{

    public function __construct(
        User $user,
        private readonly UserFilterFactory $userFilterFactory
    ) {
        parent::__construct($user);
    }

    /**
     * @return CursorPaginator
     */
    public function getUsers(GetUsersDto $getUsersDto): CursorPaginator
    {
        return $this->model->filter($this->userFilterFactory->create($getUsersDto->filter))
            ->where('role_id', '<>', RoleType::ADMIN)
            ->cursorPaginate(perPage: $getUsersDto->limit ?? 2, cursor: $getUsersDto->cursor);
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
        } catch (Throwable) {
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

}
