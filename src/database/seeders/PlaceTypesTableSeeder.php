<?php

namespace Database\Seeders;

use App\Infrastructure\Database\Models\PlaceType;
use Illuminate\Database\Seeder;

class PlaceTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $placeTypes = [
            ['name' => 'Площадь'],
            ['name' => 'Парк'],
            ['name' => 'Музей'],
            ['name' => 'Ресторан'],
            ['name' => 'Магазин'],
            ['name' => 'Спортивный объект'],
        ];

        foreach ($placeTypes as $placeType) {
            PlaceType::query()->create($placeType);
        }
    }
}
