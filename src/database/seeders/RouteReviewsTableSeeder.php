<?php

namespace Database\Seeders;

use App\Infrastructure\Database\Models\RouteReview;
use Illuminate\Database\Seeder;

class RouteReviewsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $routeReviews = [
            ['text' => 'Отличная площадь, часто здесь гуляю', 'author_id' => 1, 'route_id' => 1, 'rating' => 5],
            ['text' => 'Красивый парк, много зелени', 'author_id' => 2, 'route_id' => 2, 'rating' => 4],
            ['text' => 'Интересная экспозиция в музее', 'author_id' => 3, 'route_id' => 3, 'rating' => 4],
            ['text' => 'Большой выбор товаров в торговом центре', 'author_id' => 5, 'route_id' => 5, 'rating' => 4],
            ['text' => 'Отличная площадь, часто здесь гуляю', 'author_id' => 5, 'route_id' => 1, 'rating' => 2],
            ['text' => 'Красивый парк, много зелени', 'author_id' => 4, 'route_id' => 2, 'rating' => 3],
            ['text' => 'Интересная экспозиция в музее', 'author_id' => 6, 'route_id' => 3, 'rating' => 4],
            ['text' => 'Вкусная еда в ресторане', 'author_id' => 2, 'route_id' => 4, 'rating' => 1],
            ['text' => 'Большой выбор товаров в торговом центре', 'author_id' => 1, 'route_id' => 5, 'rating' => 4],
        ];

        foreach ($routeReviews as $routeReview) {
            RouteReview::query()->create($routeReview);
        }
    }
}
