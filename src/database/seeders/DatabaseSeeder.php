<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            VoyagerDatabaseSeeder::class,
            UserTableSeeder::class,
            LocalitiesTableSeeder::class,
            PlaceTypesTableSeeder::class,
            PlacesTableSeeder::class,
            PlaceReviewsTableSeeder::class,
            PlaceImagesTableSeeder::class,
            RoutesTableSeeder::class,
            RoutePointsTableSeeder::class,
            RouteReviewsTableSeeder::class,
            UserRouteProgressesTableSeeder::class,
            FriendRelationshipTypesTableSeeder::class,
            AchievementTypesTableSeeder::class,
            AchievementsTableSeeder::class,
            UserAchievementProgressesTableSeeder::class,
            UserScoresTableSeeder::class,
        ]);
    }
}
