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
        if (!$hexColor) {
            return $light;
        }

        $hex = ltrim($hexColor, '#');

        // Expand 3-digit hex (e.g. #FFF -> #FFFFFF)
        if (strlen($hex) === 3) {
            $hex = $hex[0] . $hex[0] . $hex . $hex . $hex . $hex;
        }

        if (strlen($hex) !== 6 || !ctype_xdigit($hex)) {
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
}