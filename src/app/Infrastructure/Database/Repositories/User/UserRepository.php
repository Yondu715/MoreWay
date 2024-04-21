<?php

namespace App\Infrastructure\Database\Repositories\User;

use App\Application\Contracts\Out\Repositories\User\IUserRepository;
use App\Application\DTO\Collection\CursorDto;
use App\Application\DTO\In\User\ChangeUserPasswordDto;
use App\Application\DTO\In\User\GetUsersDto;
use App\Application\DTO\Out\Auth\UserDto;
use App\Application\Enums\Role\RoleType;
use App\Application\Exceptions\User\UserNotFound;
use App\Infrastructure\Database\Models\Filters\User\UserFilterFactory;
use App\Infrastructure\Database\Models\User;
use App\Utils\Mappers\Out\Auth\UserDtoMapper;
use Illuminate\Database\Eloquent\Model;
use Throwable;

class UserRepository implements IUserRepository
{

    private Model $model;

    public function __construct(
        User $user,
        private readonly UserFilterFactory $userFilterFactory
    ) {
        $this->model = $user;
    }

    /**
     * @return CursorDto
     */
    public function getAll(GetUsersDto $getUsersDto): CursorDto
    {
        $paginator = $this->model->filter($this->userFilterFactory->create($getUsersDto->filter))
            ->where('role_id', '<>', RoleType::ADMIN)
            ->cursorPaginate(perPage: $getUsersDto->limit ?? 2, cursor: $getUsersDto->cursor);
        return UserDtoMapper::fromPaginator($paginator);
    }

    /**
     * @param int $id
     * @return UserDto
     * @throws UserNotFound
     */
    public function findById(int $id): UserDto
    {
        try {
            return UserDtoMapper::fromUserModel($this->model->query()->findOrFail($id));
        } catch (Throwable) {
            throw new UserNotFound();
        }
    }

    /**
     * @param string $email
     * @return UserDto|null
     */
    public function findByEmail(string $email): ?UserDto
    {
        $user = $this->model->query()->firstWhere([
            'email'  => $email
        ]);
        return $user ? UserDtoMapper::fromUserModel($user) : null;
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
     * @param user$userDto $userDto
     * @return UserDto
     */
    public function create(UserDto $userDto): UserDto
    {
        $user = $this->model->query()->create([
            'name' => $userDto->name,
            'email' => $userDto->email,
            'password' => $userDto->password
        ]);
        return UserDtoMapper::fromUserModel($user);
    }

    /**
     * @param ChangeUserPasswordDto $changeUserPasswordDto
     * @return UserDto
     */
    public function update(UserDto $userDto): UserDto
    {
        $user = $this->model->query()->find($userDto->id);
        $user->update([
            'password' => $userDto->password
        ]);
        return UserDtoMapper::fromUserModel($user->refresh());
    }

}
