<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@growpec.com'],
            [
                'name' => 'Super Admin',
                'password' => Hash::make('#GrowPec@2026'),
                'role' => 'super_admin',
                'phone' => '9999999999',
            ]
        );
    }
}
