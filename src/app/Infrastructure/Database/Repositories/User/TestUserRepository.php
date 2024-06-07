<?php

namespace App\Infrastructure\Database\Repositories\User;

use App\Infrastructure\Database\Models\User;
use App\Infrastructure\Database\Repositories\BaseRepository;
use App\Utils\Mappers\Out\User\UserDtoMapper;

class TestUserRepository extends BaseRepository
{
    protected function model(): string
    {
        return User::class;
    }

    protected function mapper(): string
    {
        return UserDtoMapper::class;
    }
}