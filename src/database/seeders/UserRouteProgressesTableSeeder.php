<?php

namespace Database\Seeders;

use App\Infrastructure\Database\Models\UserRouteProgress;
use Illuminate\Database\Seeder;

class UserRouteProgressesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $userRouteProgresses = [
            ['user_id' => 1, 'route_point_id' => 1, 'is_completed' => 1],
            ['user_id' => 1, 'route_point_id' => 2, 'is_completed' => 1],
            ['user_id' => 1, 'route_point_id' => 3, 'is_completed' => 1],
            ['user_id' => 1, 'route_point_id' => 4, 'is_completed' => 1],
            ['user_id' => 1, 'route_point_id' => 5, 'is_completed' => 1],
            ['user_id' => 2, 'route_point_id' => 6, 'is_completed' => 1],
            ['user_id' => 2, 'route_point_id' => 7, 'is_completed' => 1],
            ['user_id' => 2, 'route_point_id' => 8, 'is_completed' => 1],
            ['user_id' => 2, 'route_point_id' => 9, 'is_completed' => 1],
            ['user_id' => 2, 'route_point_id' => 10, 'is_completed' => 1],
            ['user_id' => 2, 'route_point_id' => 1, 'is_completed' => 1],
            ['user_id' => 2, 'route_point_id' => 2, 'is_completed' => 1],
            ['user_id' => 2, 'route_point_id' => 3, 'is_completed' => 1],
            ['user_id' => 2, 'route_point_id' => 4, 'is_completed' => 1],
            ['user_id' => 2, 'route_point_id' => 5, 'is_completed' => 1],
            ['user_id' => 1, 'route_point_id' => 6, 'is_completed' => 1],
        ];

        foreach ($userRouteProgresses as $userRouteProgress) {
            UserRouteProgress::query()->create($userRouteProgress);
        }
    }
}
