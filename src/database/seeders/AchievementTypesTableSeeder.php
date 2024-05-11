<?php

namespace Database\Seeders;

use App\Infrastructure\Database\Models\AchievementType;
use Illuminate\Database\Seeder;

class AchievementTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $types = [
            ['name' => 'Золото', 'value' => 30],
            ['name' => 'Серебро', 'value' => 20],
            ['name' => 'Бронза', 'value' => 10],
        ];

        foreach ($types as $type) {
            AchievementType::query()->create($type);
        }
    }
}
