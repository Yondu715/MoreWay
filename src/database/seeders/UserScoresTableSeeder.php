<?php

namespace Database\Seeders;

use App\Infrastructure\Database\Models\UserScore;
use Illuminate\Database\Seeder;

class UserScoresTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $userScores = [
            ['user_id' => 1, 'score' => 60],
            ['user_id' => 2, 'score' => 30]
        ];

        foreach ($userScores as $userScore) {
            UserScore::query()->create($userScore);
        }
    }
}
