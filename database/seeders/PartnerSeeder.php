<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PartnerSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('partners')->truncate();

        $partners = [
            ['name' => 'Amity University',               'sort_order' => 1],
            ['name' => 'Manipal University',             'sort_order' => 2],
            ['name' => 'Lovely Professional University', 'sort_order' => 3],
            ['name' => 'Chandigarh University',          'sort_order' => 4],
            ['name' => 'NMIMS University',               'sort_order' => 5],
            ['name' => 'Symbiosis University',           'sort_order' => 6],
            ['name' => 'UPES Dehradun',                  'sort_order' => 7],
            ['name' => 'Jain University',                'sort_order' => 8],
        ];

        $now = now();

        foreach ($partners as $partner) {
            DB::table('partners')->insert([
                'name' => $partner['name'],
                'logo' => null,
                'sort_order' => $partner['sort_order'],
                'status' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }
    }
}
