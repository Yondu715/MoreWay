<?php

namespace Database\Seeders;

use App\Infrastructure\Database\Models\Infrastructure\Database\Models\Application\Contracts\Out\Managers\Hash\IHashManager;
use App\Infrastructure\Database\Models\Infrastructure\Database\Models\Application\Enums\Role\RoleTypeId;
use App\Infrastructure\Database\Models\Infrastructure\Database\Models\Infrastructure\Database\Models\Locality;
use App\Infrastructure\Database\Models\Infrastructure\Database\Models\Infrastructure\Database\Models\Place;
use App\Infrastructure\Database\Models\Infrastructure\Database\Models\Infrastructure\Database\Models\PlaceImage;
use App\Infrastructure\Database\Models\Infrastructure\Database\Models\Infrastructure\Database\Models\PlaceReview;
use App\Infrastructure\Database\Models\Infrastructure\Database\Models\Infrastructure\Database\Models\PlaceType;
use App\Infrastructure\Database\Models\Infrastructure\Database\Models\Infrastructure\Database\Models\Route;
use App\Infrastructure\Database\Models\Infrastructure\Database\Models\Infrastructure\Database\Models\RoutePoint;
use App\Infrastructure\Database\Models\Infrastructure\Database\Models\Infrastructure\Database\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function __construct(
      private readonly IHashManager $hashManager
    ) {}

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->seedUsers();
        $this->seedLocalities();
        $this->seedPlaceTypes();
        $this->seedPlaces();
        $this->seedPlaceReviews();
        $this->seedPlaceImages();
        $this->seedRoutes();
        $this->seedRoutePoints();
    }

    private function seedUsers(): void
    {
        $users = [
            ['name' => 'John', 'email' => 'john@example.com', 'password' => $this->hashManager->make('123123123'), 'role_id' => RoleTypeId::USER],
            ['name' => 'Jane', 'email' => 'jane@example.com', 'password' => $this->hashManager->make('123123123'), 'role_id' => RoleTypeId::USER],
            ['name' => 'Bob', 'email' => 'bob@example.com', 'password' => $this->hashManager->make('123123123'), 'role_id' => RoleTypeId::USER],
            ['name' => 'Alice', 'email' => 'alice@example.com', 'password' => $this->hashManager->make('123123123'), 'role_id' => RoleTypeId::USER],
            ['name' => 'Tom', 'email' => 'tom@example.com', 'password' => $this->hashManager->make('123123123'), 'role_id' => RoleTypeId::USER],
            ['name' => 'Sarah', 'email' => 'sarah@example.com', 'password' => $this->hashManager->make('123123123'), 'role_id' => RoleTypeId::USER],
        ];

        foreach ($users as $user){
            User::query()->create($user);
        }
    }

    private function seedLocalities(): void
    {
        $localities = [
            ['name' => 'Кемерово'],
            ['name' => 'Новокузнецк'],
            ['name' => 'Прокопьевск'],
            ['name' => 'Ленинск-Кузнецкий'],
            ['name' => 'Киселевск'],
            ['name' => 'Междуреченск'],
        ];

        foreach ($localities as $locality){
            Locality::query()->create($locality);
        }
    }

    private function seedPlaceTypes(): void
    {
        $placeTypes = [
            ['name' => 'Площадь'],
            ['name' => 'Парк'],
            ['name' => 'Музей'],
            ['name' => 'Ресторан'],
            ['name' => 'Магазин'],
            ['name' => 'Спортивный объект'],
        ];

        foreach ($placeTypes as $placeType){
            PlaceType::query()->create($placeType);
        }
    }

    private function seedPlaces(): void
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

        foreach ($places as $place){
            Place::query()->create($place);
        }
    }

    private function seedPlaceReviews(): void
    {
        $placeReviews = [
            ['text' => 'Отличная площадь, часто здесь гуляю', 'author_id' => 1, 'place_id' => 1, 'rating' => 5],
            ['text' => 'Красивый парк, много зелени', 'author_id' => 2, 'place_id' => 2, 'rating' => 4],
            ['text' => 'Интересная экспозиция в музее', 'author_id' => 3, 'place_id' => 3, 'rating' => 4],
            ['text' => 'Вкусная еда в ресторане', 'author_id' => 4, 'place_id' => 4, 'rating' => 5],
            ['text' => 'Большой выбор товаров в торговом центре', 'author_id' => 5, 'place_id' => 5, 'rating' => 4],
            ['text' => 'Хороший стадион, часто здесь тренируюсь', 'author_id' => 6, 'place_id' => 6, 'rating' => 5],
        ];

        foreach ($placeReviews as $placeReview){
            PlaceReview::query()->create($placeReview);
        }
    }

    private function seedPlaceImages(): void
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

        foreach ($placeImages as $placeImage){
            PlaceImage::query()->create($placeImage);
        }
    }

    private function seedRoutes(): void
    {
        $routes = [
            ['name' => 'Прогулка', 'creator_id' => 1],
            ['name' => 'Экскурсия', 'creator_id' => 2],
            ['name' => 'Путешествие', 'creator_id' => 3],
            ['name' => 'Маршрут', 'creator_id' => 4],
            ['name' => 'Обзорный тур', 'creator_id' => 5],
        ];

        foreach ($routes as $route){
            Route::query()->create($route);
        }
    }

    private function seedRoutePoints(): void
    {
        $placePoints = [
            ['index' => 1, 'place_id' => 1, 'route_id' => 1],
            ['index' => 2, 'place_id' => 3, 'route_id' => 1],
            ['index' => 3, 'place_id' => 5, 'route_id' => 1],
            ['index' => 4, 'place_id' => 11, 'route_id' => 1],
            ['index' => 5, 'place_id' => 13, 'route_id' => 1],

            ['index' => 1, 'place_id' => 2, 'route_id' => 2],
            ['index' => 2, 'place_id' => 4, 'route_id' => 2],
            ['index' => 3, 'place_id' => 6, 'route_id' => 2],
            ['index' => 4, 'place_id' => 8, 'route_id' => 2],
            ['index' => 5, 'place_id' => 10, 'route_id' => 2],

            ['index' => 1, 'place_id' => 3, 'route_id' => 3],
            ['index' => 2, 'place_id' => 9, 'route_id' => 3],
            ['index' => 3, 'place_id' => 10, 'route_id' => 3],
            ['index' => 4, 'place_id' => 1, 'route_id' => 3],
            ['index' => 5, 'place_id' => 8, 'route_id' => 3],

            ['index' => 1, 'place_id' => 4, 'route_id' => 4],
            ['index' => 2, 'place_id' => 11, 'route_id' => 4],
            ['index' => 3, 'place_id' => 12, 'route_id' => 4],
            ['index' => 4, 'place_id' => 6, 'route_id' => 4],
            ['index' => 5, 'place_id' => 7, 'route_id' => 4],

            ['index' => 1, 'place_id' => 13, 'route_id' => 5],
            ['index' => 2, 'place_id' => 14, 'route_id' => 5],
            ['index' => 3, 'place_id' => 2, 'route_id' => 5],
            ['index' => 4, 'place_id' => 10, 'route_id' => 5],
            ['index' => 5, 'place_id' => 1, 'route_id' => 5],
        ];

        foreach ($placePoints as $placePoint){
            RoutePoint::query()->create($placePoint);
        }
    }
}
