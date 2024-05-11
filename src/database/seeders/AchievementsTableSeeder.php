<?php

namespace Database\Seeders;

use App\Infrastructure\Database\Models\Achievement;
use Illuminate\Database\Seeder;

class AchievementsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $achievements = [
            ['name' => 'Новичок', 'description' => 'Пройти 1 маршрут', 'target' => 1, 'type_id' => 3, 'image' => 'achievements/achievement1.jpg'],
            ['name' => 'Средничок', 'description' => 'Пройти 5 маршрут', 'target' => 5, 'type_id' => 2, 'image' => 'achievements/achievement2.jpg'],
            ['name' => 'Опытный', 'description' => 'Пройти 10 маршрут', 'target' => 10, 'type_id' => 1, 'image' => 'achievements/achievement3.jpg'],
        ];

        foreach ($achievements as $achievement) {
            Achievement::query()->create($achievement);
        }
    }
}
