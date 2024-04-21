<?php

namespace App\Infrastructure\Database\Models\Filters\User;

use App\Infrastructure\Database\Models\Filters\User\UserFilter;

class UserFilterFactory
{
    public static function create(array $filters): UserFilter
    {
        return new UserFilter($filters);
    }
}
