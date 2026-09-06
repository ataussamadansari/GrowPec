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

        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $inputs = collect($request->except(['_token', '_method', 'logo', 'footer_logo', 'favicon', 'listing_banner', 'home_banner']))
            ->reject(fn ($value, $key) => str_starts_with($key, 'theme___'))
            ->all();

        // 1. Process Key-Value string/text inputs
        foreach ($inputs as $key => $value) {
            $formattedKey = str_replace('___', '.', $key);
            $type = is_bool($value) ? 'boolean' : (strlen($value) > 255 ? 'text' : 'string');
            $group = explode('.', $formattedKey)[0] ?? 'general';

            SystemSetting::set($formattedKey, $value, $group, $type);
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

        // 3. Handle Header Logo
        if ($request->hasFile('logo')) {
            $request->validate(['logo' => 'image|mimes:jpeg,png,jpg,webp,svg|max:2048']);
            $logoPath = $request->file('logo')->store('branding', 'public');
            SystemSetting::set('general.logo', 'storage/'.$logoPath, 'general', 'image');
        }

        // 4. Handle Footer Logo
        if ($request->hasFile('footer_logo')) {
            $request->validate(['footer_logo' => 'image|mimes:jpeg,png,jpg,webp,svg|max:2048']);
            $footerLogoPath = $request->file('footer_logo')->store('branding', 'public');
            SystemSetting::set('general.footer_logo', 'storage/'.$footerLogoPath, 'general', 'image');
        }

        // 5. Handle Favicon
        if ($request->hasFile('favicon')) {
            $request->validate(['favicon' => 'mimes:png,ico,svg|max:1024']);
            $faviconPath = $request->file('favicon')->store('branding', 'public');
            SystemSetting::set('general.favicon', 'storage/'.$faviconPath, 'general', 'image');
        }

        // 🎯 6. Handle Listing Page Ad Banner Image
        if ($request->hasFile('listing_banner')) {
            $request->validate(['listing_banner' => 'image|mimes:jpeg,png,jpg,webp|max:4096']);
            $adPath = $request->file('listing_banner')->store('ads', 'public');
            SystemSetting::set('ads.listing_banner', 'storage/'.$adPath, 'ads', 'image');
        }

        // 🎯 7. Handle Homepage Mid-Page Ad Banner Image
        if ($request->hasFile('home_banner')) {
            $request->validate(['home_banner' => 'image|mimes:jpeg,png,jpg,webp|max:4096']);
            $homeAdPath = $request->file('home_banner')->store('ads', 'public');
            SystemSetting::set('ads.home_banner', 'storage/'.$homeAdPath, 'ads', 'image');
        }

        SystemSetting::clearCache();

        return redirect()->back()->with('success', 'Master system settings & ads updated successfully!');
    }
}
