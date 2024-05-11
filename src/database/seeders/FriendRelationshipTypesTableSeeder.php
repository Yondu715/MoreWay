<?php

namespace Database\Seeders;

use App\Infrastructure\Database\Models\FriendRelationshipType;
use Illuminate\Database\Seeder;

class FriendRelationshipTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $types = [
            ['name' => 'friend'],
            ['name' => 'request'],
        ];

        foreach ($types as $type) {
            FriendRelationshipType::query()->create($type);
        }
    }
}
