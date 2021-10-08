<?php

namespace Database\Seeders;

use App\Models\Team;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Team::factory()->create([
            'name' => 'Liverpool',
        ]);
        Team::factory()->create([
            'name' => 'Manchester City',
        ]);
        Team::factory()->create([
            'name' => 'Chelsea',
        ]);
        Team::factory()->create([
            'name' => 'Arsenal',
        ]);
    }
}
