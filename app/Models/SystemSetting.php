<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class SystemSetting extends Model
{
    use HasFactory;

    protected $fillable = ['key', 'value', 'group', 'type'];

    const CACHE_KEY = 'growpec_system_settings_cache';

    public static function get(string $key, $default = null)
    {
        $settings = self::getAllCached();

        return $settings[$key] ?? $default;
    }

    public static function set(string $key, $value, string $group = 'general', string $type = 'string'): void
    {
        self::updateOrCreate(
            ['key' => $key],
            ['value' => $value, 'group' => $group, 'type' => $type]
        );

        Cache::forget(self::CACHE_KEY);
    }

    public static function getAllCached(): array
    {
        return Cache::rememberForever(self::CACHE_KEY, function () {
            try {
                return self::pluck('value', 'key')->toArray();
            } catch (\Exception $e) {
                return [];
            }
        });
    }

    public static function clearCache(): void
    {
        Cache::forget(self::CACHE_KEY);
    }

    /**
     * Calculate readable contrast text color (Dark or Light)
     * WCAG Standard YIQ Luminance Formula
     */
    public static function getContrastColor(?string $hexColor, string $dark = '#111827', string $light = '#FFFFFF'): string
    {
        if (! $hexColor) {
            return $light;
        }

        $hex = ltrim($hexColor, '#');

        // Expand 3-digit hex (e.g. #FFF -> #FFFFFF)
        if (strlen($hex) === 3) {
            $hex = $hex[0].$hex[0].$hex.$hex.$hex.$hex;
        }

        if (strlen($hex) !== 6 || ! ctype_xdigit($hex)) {
            return $light;
        }

        // Extract RGB
        $r = hexdec(substr($hex, 0, 2));
        $g = hexdec(substr($hex, 2, 2));
        $b = hexdec(substr($hex, 4, 2));

        // YIQ Luminance Formula
        $yiq = (($r * 299) + ($g * 587) + ($b * 114)) / 1000;

        return ($yiq >= 150) ? $dark : $light;
    }

    /**
     * Retrieve all configured contact phone numbers.
     *
     * @return array<int, array{title: string, number: string}>
     */
    public static function getPhones(): array
    {
        $settings = self::getAllCached();
        $raw = $settings['general.support_phones'] ?? '';
        $phones = [];

        if (! empty($raw)) {
            $decoded = json_decode($raw, true);
            if (is_array($decoded)) {
                foreach ($decoded as $item) {
                    $number = is_array($item) ? ($item['number'] ?? '') : (string) $item;
                    $title = is_array($item) ? ($item['title'] ?? 'Helpline') : 'Helpline';
                    if (! empty(trim($number))) {
                        $phones[] = [
                            'title' => trim($title) ?: 'Helpline',
                            'number' => trim($number),
                        ];
                    }
                }
            } else {
                $lines = preg_split('/\r\n|\r|\n/', (string) $raw);
                foreach ($lines as $line) {
                    $line = trim($line);
                    if ($line === '') {
                        continue;
                    }
                    if (str_contains($line, ':')) {
                        [$title, $num] = explode(':', $line, 2);
                        $phones[] = ['title' => trim($title) ?: 'Helpline', 'number' => trim($num)];
                    } else {
                        $phones[] = ['title' => 'Helpline', 'number' => $line];
                    }
                }
            }
        }

        if (empty($phones) && ! empty($settings['general.support_phone'])) {
            $phones[] = [
                'title' => 'Helpline',
                'number' => trim($settings['general.support_phone']),
            ];
        }

        return $phones;
    }

    /**
     * Retrieve all configured support emails.
     *
     * @return array<int, array{title: string, email: string}>
     */
    public static function getEmails(): array
    {
        $settings = self::getAllCached();
        $raw = $settings['general.support_emails'] ?? '';
        $emails = [];

        if (! empty($raw)) {
            $decoded = json_decode($raw, true);
            if (is_array($decoded)) {
                foreach ($decoded as $item) {
                    $email = is_array($item) ? ($item['email'] ?? '') : (string) $item;
                    $title = is_array($item) ? ($item['title'] ?? 'Support Email') : 'Support Email';
                    if (! empty(trim($email))) {
                        $emails[] = [
                            'title' => trim($title) ?: 'Support Email',
                            'email' => trim($email),
                        ];
                    }
                }
            } else {
                $lines = preg_split('/\r\n|\r|\n/', (string) $raw);
                foreach ($lines as $line) {
                    $line = trim($line);
                    if ($line === '') {
                        continue;
                    }
                    if (str_contains($line, ':')) {
                        [$title, $em] = explode(':', $line, 2);
                        $emails[] = ['title' => trim($title) ?: 'Support Email', 'email' => trim($em)];
                    } else {
                        $emails[] = ['title' => 'Support Email', 'email' => $line];
                    }
                }
            }
        }

        if (empty($emails) && ! empty($settings['general.support_email'])) {
            $emails[] = [
                'title' => 'Support Email',
                'email' => trim($settings['general.support_email']),
            ];
        }

        return $emails;
    }

    /**
     * Retrieve all configured office addresses.
     *
     * @return array<int, array{title: string, address: string, map_url: string}>
     */
    public static function getAddresses(): array
    {
        $settings = self::getAllCached();
        $raw = $settings['general.office_addresses'] ?? '';
        $addresses = [];

        if (! empty($raw)) {
            $decoded = json_decode($raw, true);
            if (is_array($decoded)) {
                foreach ($decoded as $item) {
                    $addr = is_array($item) ? ($item['address'] ?? '') : (string) $item;
                    $title = is_array($item) ? ($item['title'] ?? 'Office Location') : 'Office Location';
                    $mapUrl = is_array($item) ? ($item['map_url'] ?? '') : '';
                    if (! empty(trim($addr))) {
                        $addresses[] = [
                            'title' => trim($title) ?: 'Office Location',
                            'address' => trim($addr),
                            'map_url' => trim($mapUrl),
                        ];
                    }
                }
            } else {
                $lines = preg_split('/\r\n|\r|\n/', (string) $raw);
                foreach ($lines as $line) {
                    $line = trim($line);
                    if ($line === '') {
                        continue;
                    }
                    if (str_contains($line, '---') || str_contains($line, ':')) {
                        $parts = str_contains($line, '---') ? explode('---', $line, 2) : explode(':', $line, 2);
                        $addresses[] = [
                            'title' => trim($parts[0]) ?: 'Office Location',
                            'address' => trim($parts[1]),
                            'map_url' => '',
                        ];
                    } else {
                        $addresses[] = [
                            'title' => 'Office Location',
                            'address' => $line,
                            'map_url' => '',
                        ];
                    }
                }
            }
        }

        if (empty($addresses) && ! empty($settings['general.office_address'])) {
            $addresses[] = [
                'title' => 'Head Office',
                'address' => trim($settings['general.office_address']),
                'map_url' => trim($settings['general.map_embed_url'] ?? ''),
            ];
        }

        return $addresses;
    }
}
