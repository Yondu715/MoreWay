<?php

namespace Database\Seeders;

use App\Infrastructure\Database\Models\Locality;
use Illuminate\Database\Seeder;

class LocalitiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $localities = [
            ['name' => 'Кемерово'],
            ['name' => 'Новокузнецк'],
            ['name' => 'Прокопьевск'],
            ['name' => 'Ленинск-Кузнецкий'],
            ['name' => 'Киселевск'],
            ['name' => 'Междуреченск'],
        ];

        foreach ($localities as $locality) {
            Locality::query()->create($locality);
        }
    }
}
