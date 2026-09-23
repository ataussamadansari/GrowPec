<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            AdminSeeder::class,          // 1. Users first
            StateCitySeeder::class,      // 2. Locations
            SystemSettingSeeder::class,  // 3. Site settings
            PartnerSeeder::class,        // 4. Partner logos
            CollegeSeeder::class,        // 5. Colleges + all child data
        ]);
    }
}
