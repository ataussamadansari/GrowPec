<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SystemSetting;
use Illuminate\Http\Request;

class MasterSettingController extends Controller
{
    public function index()
    {
        $settings = SystemSetting::getAllCached();
        $phones = SystemSetting::getPhones();
        $emails = SystemSetting::getEmails();
        $addresses = SystemSetting::getAddresses();

        return view('admin.settings.index', compact('settings', 'phones', 'emails', 'addresses'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'general___tagline' => ['nullable', 'string', 'max:180'],
            'general___seo_title' => ['nullable', 'string', 'max:70'],
            'general___site_description' => ['nullable', 'string', 'max:320'],
            'general___site_keywords' => ['nullable', 'string', 'max:500'],
            'general___map_embed_url' => [
                'nullable',
                'url:https',
                'max:2048',
                function (string $attribute, mixed $value, \Closure $fail): void {
                    if ($value === null || $value === '') {
                        return;
                    }

                    $host = strtolower((string) parse_url($value, PHP_URL_HOST));
                    $path = (string) parse_url($value, PHP_URL_PATH);

                    if ($host !== 'www.google.com' || ! str_starts_with($path, '/maps/embed')) {
                        $fail('Use the Google Maps embed URL copied from Google Maps.');
                    }
                },
            ],
            'social___facebook' => ['nullable', 'url:http,https', 'max:255'],
            'social___instagram' => ['nullable', 'url:http,https', 'max:255'],
            'social___linkedin' => ['nullable', 'url:http,https', 'max:255'],
            'social___youtube' => ['nullable', 'url:http,https', 'max:255'],
            'social___twitter' => ['nullable', 'url:http,https', 'max:255'],
        ]);

        $inputs = collect($request->except([
            '_token',
            '_method',
            'listing_banner',
            'home_banner',
            'support_phones',
            'support_emails',
            'office_addresses',
        ]))
            ->reject(fn ($value, $key) => str_starts_with($key, 'theme___'))
            ->all();

        // 1. Process Key-Value string/text inputs
        foreach ($inputs as $key => $value) {
            if (is_array($value)) {
                continue;
            }
            $formattedKey = str_replace('___', '.', $key);
            $type = is_bool($value) ? 'boolean' : (is_string($value) && strlen($value) > 255 ? 'text' : 'string');
            $group = explode('.', $formattedKey)[0] ?? 'general';

            SystemSetting::set($formattedKey, $value, $group, $type);
        }

        // Process Multi-Phones
        if ($request->has('support_phones') && is_array($request->input('support_phones'))) {
            $phones = collect($request->input('support_phones'))
                ->filter(fn ($item) => is_array($item) && ! empty(trim($item['number'] ?? '')))
                ->map(fn ($item) => [
                    'title' => trim($item['title'] ?? '') ?: 'Helpline',
                    'number' => trim($item['number'] ?? ''),
                ])
                ->values()
                ->all();

            SystemSetting::set('general.support_phones', json_encode($phones), 'general', 'text');
            if (! empty($phones)) {
                SystemSetting::set('general.support_phone', $phones[0]['number'], 'general', 'string');
            }
        }

        // Process Multi-Emails
        if ($request->has('support_emails') && is_array($request->input('support_emails'))) {
            $emails = collect($request->input('support_emails'))
                ->filter(fn ($item) => is_array($item) && ! empty(trim($item['email'] ?? '')))
                ->map(fn ($item) => [
                    'title' => trim($item['title'] ?? '') ?: 'Support Email',
                    'email' => trim($item['email'] ?? ''),
                ])
                ->values()
                ->all();

            SystemSetting::set('general.support_emails', json_encode($emails), 'general', 'text');
            if (! empty($emails)) {
                SystemSetting::set('general.support_email', $emails[0]['email'], 'general', 'string');
            }
        }

        // Process Multi-Addresses
        if ($request->has('office_addresses') && is_array($request->input('office_addresses'))) {
            $addresses = collect($request->input('office_addresses'))
                ->filter(fn ($item) => is_array($item) && ! empty(trim($item['address'] ?? '')))
                ->map(function ($item) {
                    $rawMap = trim($item['map_url'] ?? '');
                    if (preg_match('/src=["\']([^"\']+)["\']/i', $rawMap, $m)) {
                        $rawMap = $m[1];
                    }

                    return [
                        'title' => trim($item['title'] ?? '') ?: 'Office Location',
                        'address' => trim($item['address'] ?? ''),
                        'map_url' => $rawMap,
                    ];
                })
                ->values()
                ->all();

            SystemSetting::set('general.office_addresses', json_encode($addresses), 'general', 'text');
            if (! empty($addresses)) {
                SystemSetting::set('general.office_address', $addresses[0]['address'], 'general', 'text');
                if (! empty($addresses[0]['map_url'])) {
                    SystemSetting::set('general.map_embed_url', $addresses[0]['map_url'], 'general', 'string');
                }
            }
        }

        if ($request->has('general___tagline')) {
            SystemSetting::set('general.site_tagline', $request->input('general___tagline'), 'general', 'string');
        }

        // 2. Handle Feature & Ad Toggles (Checkboxes)
        $booleanToggles = [
            'features.enable_online_colleges',
            'features.enable_floating_whatsapp',
            'features.enable_lead_email_alert',
            'features.enable_partner_strip',
            'features.maintenance_mode',
            'ads.enable_listing_ad', // 🎯 Listing Page Ad Show/Hide
            'ads.enable_home_ad',    // 🎯 Homepage Ad Show/Hide
        ];

        foreach ($booleanToggles as $toggle) {
            $encodedKey = str_replace('.', '___', $toggle);
            $val = $request->has($encodedKey) ? '1' : '0';
            $group = explode('.', $toggle)[0] ?? 'features';
            SystemSetting::set($toggle, $val, $group, 'boolean');
        }

        // Handle listing page ad banner image.
        if ($request->hasFile('listing_banner')) {
            $request->validate(['listing_banner' => 'image|mimes:jpeg,png,jpg,webp|max:4096']);
            $adPath = $request->file('listing_banner')->store('ads', 'public');
            SystemSetting::set('ads.listing_banner', 'storage/'.$adPath, 'ads', 'image');
        }

        // Handle homepage mid-page ad banner image.
        if ($request->hasFile('home_banner')) {
            $request->validate(['home_banner' => 'image|mimes:jpeg,png,jpg,webp|max:4096']);
            $homeAdPath = $request->file('home_banner')->store('ads', 'public');
            SystemSetting::set('ads.home_banner', 'storage/'.$homeAdPath, 'ads', 'image');
        }

        SystemSetting::clearCache();

        return redirect()->back()->with('success', 'Master system settings & ads updated successfully!');
    }
}
