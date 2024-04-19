<?php

namespace Database\Seeders;

use App\Infrastructure\Database\Models\PlaceReview;
use Illuminate\Database\Seeder;

class PlaceReviewsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $placeReviews = [
            ['text' => 'Отличная площадь, часто здесь гуляю', 'author_id' => 1, 'place_id' => 1, 'rating' => 5],
            ['text' => 'Красивый парк, много зелени', 'author_id' => 2, 'place_id' => 2, 'rating' => 4],
            ['text' => 'Интересная экспозиция в музее', 'author_id' => 3, 'place_id' => 3, 'rating' => 4],
            ['text' => 'Вкусная еда в ресторане', 'author_id' => 4, 'place_id' => 4, 'rating' => 5],
            ['text' => 'Большой выбор товаров в торговом центре', 'author_id' => 5, 'place_id' => 5, 'rating' => 4],
            ['text' => 'Хороший стадион, часто здесь тренируюсь', 'author_id' => 6, 'place_id' => 6, 'rating' => 5],
        ];

        foreach ($placeReviews as $placeReview) {
            PlaceReview::query()->create($placeReview);
        }
    }
}
