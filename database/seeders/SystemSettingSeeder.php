<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SystemSetting;

class SystemSettingSeeder extends Seeder
{
    public function run(): void
    {
        $defaults = [
            // 1. General & SEO
            ['key' => 'general.site_name', 'value' => 'GrowPEC', 'group' => 'general', 'type' => 'string'],
            ['key' => 'general.site_tagline', 'value' => 'Your Career Deserves A Better College', 'group' => 'general', 'type' => 'string'],
            ['key' => 'general.site_description', 'value' => 'Compare verified college fees, check UGC & AICTE approvals, scholarships, and connect with top counselors 100% free.', 'group' => 'general', 'type' => 'text'],
            ['key' => 'general.support_phone', 'value' => '+91 8858285271', 'group' => 'general', 'type' => 'string'],
            ['key' => 'general.support_email', 'value' => 'info@growpec.com', 'group' => 'general', 'type' => 'string'],
            ['key' => 'general.whatsapp_number', 'value' => '918858285271', 'group' => 'general', 'type' => 'string'],
            ['key' => 'general.office_address', 'value' => 'Varanasi, Uttar Pradesh, India', 'group' => 'general', 'type' => 'text'],
            ['key' => 'general.logo', 'value' => 'assets/growpec.png', 'group' => 'general', 'type' => 'image'],
            ['key' => 'general.footer_logo', 'value' => 'assets/growpec.png', 'group' => 'general', 'type' => 'image'],
            ['key' => 'general.favicon', 'value' => 'assets/growpec.png', 'group' => 'general', 'type' => 'image'],

            // 2. UI Theme & Colors
            ['key' => 'theme.primary_color', 'value' => '#2E1E6B', 'group' => 'theme', 'type' => 'string'],
            ['key' => 'theme.secondary_purple', 'value' => '#4E3797', 'group' => 'theme', 'type' => 'string'],
            ['key' => 'theme.accent_gold', 'value' => '#F5A623', 'group' => 'theme', 'type' => 'string'],
            ['key' => 'theme.topbar_color', 'value' => '#F5A623', 'group' => 'theme', 'type' => 'string'],
            ['key' => 'theme.body_bg', 'value' => '#F8F9FC', 'group' => 'theme', 'type' => 'string'],

            // 3. Feature Switches
            ['key' => 'features.enable_otp_login', 'value' => '1', 'group' => 'features', 'type' => 'boolean'],
            ['key' => 'features.enable_online_colleges', 'value' => '1', 'group' => 'features', 'type' => 'boolean'],
            ['key' => 'features.enable_partner_strip', 'value' => '1', 'group' => 'features', 'type' => 'boolean'],
            ['key' => 'features.enable_floating_whatsapp', 'value' => '1', 'group' => 'features', 'type' => 'boolean'],
            ['key' => 'features.enable_lead_email_alert', 'value' => '1', 'group' => 'features', 'type' => 'boolean'],
            ['key' => 'features.maintenance_mode', 'value' => '0', 'group' => 'features', 'type' => 'boolean'],

            // 🎯 4. Advertisement Banners (Only Image + Show/Hide)
            ['key' => 'ads.enable_listing_ad', 'value' => '1', 'group' => 'ads', 'type' => 'boolean'],
            ['key' => 'ads.listing_banner', 'value' => 'assets/hero_b1.jpg', 'group' => 'ads', 'type' => 'image'],
            ['key' => 'ads.listing_banner_link', 'value' => 'tel:+918858285271', 'group' => 'ads', 'type' => 'string'],

            ['key' => 'ads.enable_home_ad', 'value' => '1', 'group' => 'ads', 'type' => 'boolean'],
            ['key' => 'ads.home_banner', 'value' => 'assets/hero_b2.jpg', 'group' => 'ads', 'type' => 'image'],
            ['key' => 'ads.home_banner_link', 'value' => 'tel:+918858285271', 'group' => 'ads', 'type' => 'string'],

            // 5. APIs
            ['key' => 'api.sms_provider', 'value' => 'demo', 'group' => 'apis', 'type' => 'string'],
            ['key' => 'api.fast2sms_key', 'value' => '', 'group' => 'apis', 'type' => 'string'],
            ['key' => 'api.fcm_server_key', 'value' => '', 'group' => 'apis', 'type' => 'string'],
            ['key' => 'api.fcm_project_id', 'value' => '', 'group' => 'apis', 'type' => 'string'],
            ['key' => 'api.google_analytics_id', 'value' => '', 'group' => 'apis', 'type' => 'string'],
        ];

        foreach ($defaults as $item) {
            SystemSetting::updateOrCreate(['key' => $item['key']], $item);
        }
    }
}