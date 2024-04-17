<?php

namespace Database\Seeders;

use App\Infrastructure\Database\Models\PlaceImage;
use Illuminate\Database\Seeder;

class PlaceImagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $placeImages = [
            ['image' => 'place1.jpg', 'place_id' => 1],
            ['image' => 'place2.jpg', 'place_id' => 2],
            ['image' => 'place3_1.jpg', 'place_id' => 3],
            ['image' => 'place4_1.jpg', 'place_id' => 4],
            ['image' => 'place5_1.jpg', 'place_id' => 5],
            ['image' => 'place6_1.jpg', 'place_id' => 6],
            ['image' => 'place7.jpg', 'place_id' => 7],
            ['image' => 'place8.jpg', 'place_id' => 8],
            ['image' => 'place9.jpg', 'place_id' => 9],
            ['image' => 'place10.jpg', 'place_id' => 10],
            ['image' => 'place11.jpg', 'place_id' => 11],
            ['image' => 'place12.jpg', 'place_id' => 12],
            ['image' => 'place13.jpg', 'place_id' => 13],
            ['image' => 'place14.jpg', 'place_id' => 1],
            ['image' => 'place3_2.jpg', 'place_id' => 3],
            ['image' => 'place4_2.jpg', 'place_id' => 4],
            ['image' => 'place5_2.jpg', 'place_id' => 5],
            ['image' => 'place6_2.jpg', 'place_id' => 6],
        ];

        foreach ($placeImages as $placeImage) {
            PlaceImage::query()->create($placeImage);
        }
    }
}
