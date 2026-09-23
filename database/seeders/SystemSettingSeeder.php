<?php

namespace Database\Seeders;

use App\Models\SystemSetting;
use Illuminate\Database\Seeder;

class SystemSettingSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            // General
            ['key' => 'general.site_name',      'value' => 'GrowPec',                          'group' => 'general', 'type' => 'string'],
            ['key' => 'general.tagline',         'value' => 'Discover. Apply. Grow.',           'group' => 'general', 'type' => 'string'],
            ['key' => 'general.support_phone',   'value' => '9876543210',                       'group' => 'general', 'type' => 'string'],
            ['key' => 'general.whatsapp_number', 'value' => '919876543210',                     'group' => 'general', 'type' => 'string'],
            ['key' => 'general.support_email',   'value' => 'support@growpec.com',              'group' => 'general', 'type' => 'string'],
            ['key' => 'general.office_address',  'value' => 'GrowPec Education Pvt. Ltd., India', 'group' => 'general', 'type' => 'string'],
            ['key' => 'general.logo',            'value' => '',                                 'group' => 'general', 'type' => 'file'],
            ['key' => 'general.footer_logo',     'value' => '',                                 'group' => 'general', 'type' => 'file'],
            ['key' => 'general.favicon',         'value' => '',                                 'group' => 'general', 'type' => 'file'],

            // Theme
            ['key' => 'theme.primary_color',     'value' => '#002B67',                          'group' => 'theme',   'type' => 'color'],
            ['key' => 'theme.secondary_color',   'value' => '#008A43',                          'group' => 'theme',   'type' => 'color'],
            ['key' => 'theme.accent_gold',       'value' => '#D9A400',                          'group' => 'theme',   'type' => 'color'],

            // Features
            ['key' => 'features.maintenance_mode',         'value' => '0', 'group' => 'features', 'type' => 'boolean'],
            ['key' => 'features.enable_online_colleges',   'value' => '1', 'group' => 'features', 'type' => 'boolean'],
            ['key' => 'features.enable_floating_whatsapp', 'value' => '1', 'group' => 'features', 'type' => 'boolean'],
            ['key' => 'features.enable_lead_email_alert',  'value' => '1', 'group' => 'features', 'type' => 'boolean'],
            ['key' => 'features.enable_partner_strip',     'value' => '1', 'group' => 'features', 'type' => 'boolean'],

            // Ads
            ['key' => 'ads.enable_listing_ad',  'value' => '0', 'group' => 'ads', 'type' => 'boolean'],
            ['key' => 'ads.enable_home_ad',     'value' => '0', 'group' => 'ads', 'type' => 'boolean'],
            ['key' => 'ads.listing_banner',     'value' => '', 'group' => 'ads',  'type' => 'file'],
            ['key' => 'ads.home_banner',        'value' => '', 'group' => 'ads',  'type' => 'file'],

            // Social
            ['key' => 'social.facebook',  'value' => 'https://facebook.com/growpec',  'group' => 'social', 'type' => 'string'],
            ['key' => 'social.instagram', 'value' => 'https://instagram.com/growpec', 'group' => 'social', 'type' => 'string'],
            ['key' => 'social.youtube',   'value' => '',                              'group' => 'social', 'type' => 'string'],
            ['key' => 'social.linkedin',  'value' => '',                              'group' => 'social', 'type' => 'string'],
            ['key' => 'social.twitter',   'value' => '',                              'group' => 'social', 'type' => 'string'],
        ];

        $now = now();

        foreach ($settings as $setting) {
            SystemSetting::updateOrCreate(
                ['key' => $setting['key']],
                [
                    'value' => $setting['value'],
                    'group' => $setting['group'],
                    'type' => $setting['type'],
                    'created_at' => $now,
                    'updated_at' => $now,
                ]
            );
        }

        SystemSetting::clearCache();
    }
}
