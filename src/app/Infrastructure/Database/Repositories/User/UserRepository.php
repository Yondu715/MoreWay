<?php

namespace App\Infrastructure\Database\Repositories\User;

use App\Application\Contracts\Out\Repositories\User\IUserRepository;
use App\Application\DTO\Collection\CursorDto;
use App\Application\DTO\In\User\ChangeUserAvatarDto;
use App\Application\DTO\In\User\GetUsersDto;
use App\Application\DTO\Out\User\UserDto;
use App\Application\Enums\Role\RoleType;
use App\Application\Exceptions\User\UserNotFound;
use App\Infrastructure\Database\Models\Filters\User\UserFilterFactory;
use App\Infrastructure\Database\Models\User;
use App\Utils\Mappers\Out\User\UserDtoMapper;
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
     * @param GetUsersDto $getUsersDto
     * @return CursorDto
     */
    public function getAll(GetUsersDto $getUsersDto): CursorDto
    {
        $paginator = $this->model->filter($this->userFilterFactory->create($getUsersDto->filter))
            ->where('role_id', '<>', RoleType::ADMIN)
            ->cursorPaginate(perPage: $getUsersDto->limit, cursor: $getUsersDto->cursor);
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
            /** @var User $user */
            $user = $this->model->query()->findOrFail($id);
            return UserDtoMapper::fromUserModel($user);
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
        /** @var User $user */
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
     * @param UserDto $userDto
     * @return UserDto
     */
    public function create(UserDto $userDto): UserDto
    {
        /** @var User $user */
        $user = $this->model->query()->create([
            'name' => $userDto->name,
            'email' => $userDto->email,
            'password' => $userDto->password
        ]);
        return UserDtoMapper::fromUserModel($user);
    }

    /**
     * @param UserDto $userDto
     * @return UserDto
     */
    public function update(UserDto $userDto): UserDto
    {
        /** @var User $user */
        $user = $this->model->query()->find($userDto->id);
        $user->update([
            'password' => $userDto->password
        ]);
        return UserDtoMapper::fromUserModel($user->refresh());
    }

    /**
     * @param int $userId
     * @param string $path
     * @return UserDto
     */
    public function updateAvatar(int $userId, string $path): UserDto
    {
        /** @var User $user */
        $user = $this->model->query()->find($userId);
        $user->update([
            'avatar' => $path
        ]);
        return UserDtoMapper::fromUserModel($user->refresh());
    }
}
