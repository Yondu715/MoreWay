<?php

namespace Database\Seeders;

use App\Infrastructure\Database\Models\UserAchievementProgress;
use Illuminate\Database\Seeder;

class UserAchievementProgressesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $userProgresses = [
            ['user_id' => 1, 'achievement_id' => 1, 'progress' => 1],
            ['user_id' => 1, 'achievement_id' => 2, 'progress' => 2],
            ['user_id' => 1, 'achievement_id' => 3, 'progress' => 2],
            ['user_id' => 2, 'achievement_id' => 1, 'progress' => 1],
            ['user_id' => 2, 'achievement_id' => 2, 'progress' => 1],
        ];

        foreach ($userProgresses as $userProgress) {
            UserAchievementProgress::query()->create($userProgress);
        }
    }
}
