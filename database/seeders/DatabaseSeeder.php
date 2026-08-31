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
        /*
         * IMPORTANT:
         * Do not use User::factory() here.
         * Production Docker image installs --no-dev,
         * so Faker may not be available.
         */

        $this->call([
            StateCitySeeder::class,
            CollegePortalSeeder::class,
        ]);
    }
}