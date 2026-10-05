<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            AdminSeeder::class,                      // 1. Admin users
            StateCitySeeder::class,                  // 2. States & Cities
            SystemSettingSeeder::class,              // 3. Site settings & Contact info
            PartnerSeeder::class,                    // 4. Partner logos
            StreamCourseSpecializationSeeder::class, // 5. Streams, Courses & Specializations
            RegularCollegeSeeder::class,             // 6. Regular Campus Colleges & Universities
        ]);
    }
}
