<?php

namespace Database\Seeders;

use App\Models\Property;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PropertySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Property::insert([
            [
                'wp_post_id' => 1,
                'title' => 'property 1',
                'content' => 'property 1',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'wp_post_id' => 2,
                'title' => 'property 2',
                'content' => 'property 2',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
