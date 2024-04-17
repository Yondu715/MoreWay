<?php

namespace Database\Seeders;

use App\Application\Enums\Role\RoleTypeId;
use App\Infrastructure\Database\Models\User;
use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            ['name' => 'John', 'email' => 'john@example.com', 'password' => '123123123', 'role_id' => RoleTypeId::USER],
            ['name' => 'Jane', 'email' => 'jane@example.com', 'password' => '123123123', 'role_id' => RoleTypeId::USER],
            ['name' => 'Bob', 'email' => 'bob@example.com', 'password' => '123123123', 'role_id' => RoleTypeId::USER],
            ['name' => 'Alice', 'email' => 'alice@example.com', 'password' => '123123123', 'role_id' => RoleTypeId::USER],
            ['name' => 'Tom', 'email' => 'tom@example.com', 'password' => '123123123', 'role_id' => RoleTypeId::USER],
            ['name' => 'Sarah', 'email' => 'sarah@example.com', 'password' => '123123123', 'role_id' => RoleTypeId::USER],
        ];

        foreach ($users as $user) {
            User::query()->create($user);
        }
    }
}
