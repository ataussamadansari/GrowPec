<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use RuntimeException;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::firstOrNew(['email' => 'admin@growpec.com']);
        $admin->fill([
            'name' => 'Super Admin',
            'role' => 'super_admin',
            'phone' => '9999999999',
        ]);

        if (! $admin->exists) {
            $password = config('app.admin_seed_password');

            if (! $password) {
                throw new RuntimeException('Set ADMIN_SEED_PASSWORD to create the initial admin account.');
            }

            $admin->password = Hash::make($password);
        }

        $admin->save();
    }
}
