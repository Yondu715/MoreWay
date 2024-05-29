<?php

namespace App\Infrastructure\Database\Repositories\User;

use Throwable;
use Illuminate\Database\Eloquent\Model;
use App\Application\Enums\Role\RoleType;
use App\Application\DTO\Out\User\UserDto;
use App\Application\DTO\In\Auth\RegisterDto;
use App\Application\DTO\In\User\GetUsersDto;
use App\Infrastructure\Database\Models\User;
use App\Application\DTO\Collection\CursorDto;
use App\Utils\Mappers\Out\User\UserDtoMapper;
use App\Application\Exceptions\User\UserNotFound;
use App\Application\DTO\In\User\ChangeUserDataDto;
use App\Application\Contracts\Out\Repositories\User\IUserRepository;
use App\Infrastructure\Database\Models\Filters\User\UserFilterFactory;

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
     * @return UserDto
     */
    public function findByEmail(string $email): UserDto
    {
        /** @var User $user */
        $user = $this->model->query()->firstWhere([
            'email'  => $email
        ]);

        if (!$user) {
            throw new UserNotFound();
        }
        return UserDtoMapper::fromUserModel($user);
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
     * @param RegisterDto $userDto
     * @return UserDto
     */
    public function create(RegisterDto $registerDto): UserDto
    {
        /** @var User $user */
        $user = $this->model->query()->create([
            'name' => $registerDto->name,
            'email' => $registerDto->email,
            'password' => $registerDto->password
        ]);

        $user->score()->create([
            'score' => 0
        ]);
        return UserDtoMapper::fromUserModel($user);
    }

    /**
     * @param ChangeUserDataDto $userDto
     * @return UserDto
     */
    public function update(ChangeUserDataDto $changeUserDataDto): UserDto
    {
        /** @var User $user */
        $user = $this->model->query()->find($changeUserDataDto->userId);
        $user->update([
            'name' => $changeUserDataDto->name
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

    /**
     * @param int $userId
     * @param string $password
     * @return UserDto
     */
    public function updatePassword(int $userId, string $password): UserDto
    {
        $user = $this->model->query()->find($userId);
        $user->update([
            'password' => $password
        ]);
        return UserDtoMapper::fromUserModel($user->refresh());
    }
}
