<?php

namespace Database\Seeders;

use App\Infrastructure\Database\Models\Place;
use Illuminate\Database\Seeder;

class PlacesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $places = [
            ['name' => 'Площадь Советов', 'description' => 'Центральная площадь Кемерово', 'lat' => 55.3545, 'lon' => 86.0531, 'locality_id' => 1, 'type_id' => 1],
            ['name' => 'Парк Победы', 'description' => 'Большой парк в Новокузнецке', 'lat' => 53.7578, 'lon' => 87.1178, 'locality_id' => 2, 'type_id' => 2],
            ['name' => 'Краеведческий музей', 'description' => 'Музей, посвященный истории Кузбасса', 'lat' => 54.9032, 'lon' => 85.9831, 'locality_id' => 3, 'type_id' => 3],
            ['name' => 'Ресторан "Сибирь"', 'description' => 'Ресторан сибирской кухни в Ленинске-Кузнецком', 'lat' => 54.6548, 'lon' => 86.1764, 'locality_id' => 4, 'type_id' => 4],
            ['name' => 'Площадь Весенняя', 'description' => 'Уютная площадь в центре Кемерово', 'lat' => 55.3612, 'lon' => 86.0614, 'locality_id' => 1, 'type_id' => 1],
            ['name' => 'Парк Юбилейный', 'description' => 'Большой парк в Новокузнецке', 'lat' => 53.7489, 'lon' => 87.1058, 'locality_id' => 2, 'type_id' => 2],
            ['name' => 'Музей-заповедник "Томская Писаница"', 'description' => 'Музей под открытым небом в Кемерово', 'lat' => 55.4053, 'lon' => 86.0592, 'locality_id' => 1, 'type_id' => 3],
            ['name' => 'Ресторан "Сибирские просторы"', 'description' => 'Ресторан с видом на Кузнецкий Алатау', 'lat' => 53.7895, 'lon' => 87.2154, 'locality_id' => 2, 'type_id' => 4],
            ['name' => 'ТЦ "Универсам"', 'description' => 'Крупный торговый центр в Прокопьевске', 'lat' => 53.8612, 'lon' => 86.7143, 'locality_id' => 3, 'type_id' => 5],
            ['name' => 'Стадион "Шахтер"', 'description' => 'Стадион футбольного клуба "Шахтер" в Прокопьевске', 'lat' => 53.8705, 'lon' => 86.7032, 'locality_id' => 3, 'type_id' => 6],
            ['name' => 'Площадь Ленина', 'description' => 'Главная площадь Ленинска-Кузнецкого', 'lat' => 54.6478, 'lon' => 86.1841, 'locality_id' => 4, 'type_id' => 1],
            ['name' => 'Парк Культуры и Отдыха', 'description' => 'Большой парк в Киселевске', 'lat' => 54.0412, 'lon' => 86.6321, 'locality_id' => 5, 'type_id' => 2],
            ['name' => 'Краеведческий музей Междуреченска', 'description' => 'Музей, рассказывающий об истории Междуреченска', 'lat' => 53.6912, 'lon' => 88.0745, 'locality_id' => 6, 'type_id' => 3],
            ['name' => 'Ресторан "Кузбасс"', 'description' => 'Ресторан, специализирующийся на блюдах кузбасской кухни', 'lat' => 53.6798, 'lon' => 88.0632, 'locality_id' => 6, 'type_id' => 4],
        ];

        foreach ($places as $place) {
            Place::query()->create($place);
        }
    }
}
