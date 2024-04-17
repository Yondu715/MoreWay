<?php

namespace Database\Seeders;

use App\Infrastructure\Database\Models\Route;
use Illuminate\Database\Seeder;

class RoutesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $routes = [
            ['name' => 'Прогулка', 'creator_id' => 1],
            ['name' => 'Экскурсия', 'creator_id' => 2],
            ['name' => 'Путешествие', 'creator_id' => 3],
            ['name' => 'Маршрут', 'creator_id' => 4],
            ['name' => 'Обзорный тур', 'creator_id' => 5],
        ];

        foreach ($routes as $route) {
            Route::query()->create($route);
        }
    }
}
