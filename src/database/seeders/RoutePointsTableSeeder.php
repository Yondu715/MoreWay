<?php

namespace Database\Seeders;

use App\Infrastructure\Database\Models\RoutePoint;
use Illuminate\Database\Seeder;

class RoutePointsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
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

            ['index' => 1, 'place_id' => 13, 'route_id' => 5],
            ['index' => 2, 'place_id' => 14, 'route_id' => 5],
            ['index' => 3, 'place_id' => 2, 'route_id' => 5],
            ['index' => 4, 'place_id' => 10, 'route_id' => 5],
        ];

        foreach ($placePoints as $placePoint) {
            RoutePoint::query()->create($placePoint);
        }
    }
}
