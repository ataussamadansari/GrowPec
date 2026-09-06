<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Partner;
use App\Models\SystemSetting;

class PartnerSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Show/Hide toggle default ON
        SystemSetting::set('features.enable_partner_strip', '1', 'features', 'boolean');
        SystemSetting::set('general.partner_strip_title', 'Explore 300+ Best-Matched Partner Universities', 'general', 'string');

        // 2. High-res University Logos (Images Only)
        $partners = [
            [
                'name'       => 'Amity University',
                'logo'       => 'https://upload.wikimedia.org/wikipedia/en/thumb/f/fa/Amity_University_logo.png/220px-Amity_University_logo.png',
                'sort_order' => 1
            ],
            [
                'name'       => 'Lovely Professional University (LPU)',
                'logo'       => 'https://upload.wikimedia.org/wikipedia/en/thumb/1/1b/Lovely_Professional_University_logo.png/220px-Lovely_Professional_University_logo.png',
                'sort_order' => 2
            ],
            [
                'name'       => 'Chandigarh University',
                'logo'       => 'https://upload.wikimedia.org/wikipedia/en/thumb/d/d7/Chandigarh_University_seal.svg/220px-Chandigarh_University_seal.svg.png',
                'sort_order' => 3
            ],
            [
                'name'       => 'Manipal University Online',
                'logo'       => 'https://upload.wikimedia.org/wikipedia/en/thumb/e/e5/Manipal_University_Jaipur_logo.png/220px-Manipal_University_Jaipur_logo.png',
                'sort_order' => 4
            ],
            [
                'name'       => 'Sharda University',
                'logo'       => 'https://upload.wikimedia.org/wikipedia/en/thumb/3/30/Sharda_University_logo.png/220px-Sharda_University_logo.png',
                'sort_order' => 5
            ],
            [
                'name'       => 'D.Y. Patil University',
                'logo'       => 'https://upload.wikimedia.org/wikipedia/en/thumb/7/77/D._Y._Patil_University_Logo.png/220px-D._Y._Patil_University_Logo.png',
                'sort_order' => 6
            ],
            [
                'name'       => 'Ganpat University',
                'logo'       => 'https://upload.wikimedia.org/wikipedia/en/thumb/8/87/Ganpat_University_logo.png/220px-Ganpat_University_logo.png',
                'sort_order' => 7
            ],
            [
                'name'       => 'Quantum University',
                'logo'       => 'https://upload.wikimedia.org/wikipedia/en/thumb/9/90/Quantum_University_logo.png/220px-Quantum_University_logo.png',
                'sort_order' => 8
            ],
        ];

        foreach ($partners as $item) {
            Partner::updateOrCreate(
                ['name' => $item['name']],
                [
                    'logo'       => $item['logo'],
                    'sort_order' => $item['sort_order'],
                    'status'     => true,
                ]
            );
        }
    }
}
