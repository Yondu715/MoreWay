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
            ['image' => 'places/place1.jpg', 'place_id' => 1],
            ['image' => 'places/place2.jpg', 'place_id' => 2],
            ['image' => 'places/place3_1.jpg', 'place_id' => 3],
            ['image' => 'places/place4_1.jpg', 'place_id' => 4],
            ['image' => 'places/place5_1.jpg', 'place_id' => 5],
            ['image' => 'places/place6_1.jpg', 'place_id' => 6],
            ['image' => 'places/place7.jpg', 'place_id' => 7],
            ['image' => 'places/place8.jpg', 'place_id' => 8],
            ['image' => 'places/place9.jpg', 'place_id' => 9],
            ['image' => 'places/place10.jpg', 'place_id' => 10],
            ['image' => 'places/place11.jpg', 'place_id' => 11],
            ['image' => 'places/place12.jpg', 'place_id' => 12],
            ['image' => 'places/place13.jpg', 'place_id' => 13],
            ['image' => 'places/place14.jpg', 'place_id' => 1],
            ['image' => 'places/place3_2.jpg', 'place_id' => 3],
            ['image' => 'places/place4_2.jpg', 'place_id' => 4],
            ['image' => 'places/place5_2.jpg', 'place_id' => 5],
            ['image' => 'places/place6_2.jpg', 'place_id' => 6],
        ];

        foreach ($placeImages as $placeImage) {
            PlaceImage::query()->create($placeImage);
        }
    }
}
