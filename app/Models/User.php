<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'gender',
        'dob',
        'state',
        'city',
        'address',
        'avatar',
        'role',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'dob'               => 'date',
            'password'          => 'hashed',
        ];
    }

    /**
     * 🎯 1. Standardize Indian Phone Number to strictly 10 Digits
     * Strips +91, 91, leading 0, spaces, and dashes
     */
    public static function sanitizePhone(?string $phone): ?string
    {
        if (!$phone) return null;

        // Strip non-digits
        $digits = preg_replace('/\D/', '', $phone);

        // Remove leading 0 (e.g. 08858285271 -> 8858285271)
        if (strlen($digits) === 11 && str_starts_with($digits, '0')) {
            $digits = substr($digits, 1);
        }

        // Remove country code 91 (e.g. 918858285271 -> 8858285271)
        if (strlen($digits) === 12 && str_starts_with($digits, '91')) {
            $digits = substr($digits, 2);
        }

        // Return exact 10 digits
        return strlen($digits) >= 10 ? substr($digits, -10) : $digits;
    }

    /**
     * 🎯 2. Always store normalized 10-digit phone in DB
     */
    public function setPhoneAttribute($value)
    {
        $this->attributes['phone'] = self::sanitizePhone($value);
    }

    /**
     * 🎯 3. Find User by Any Phone Format
     */
    public static function findByPhone(?string $phone): ?self
    {
        $clean = self::sanitizePhone($phone);
        if (!$clean) return null;

        return self::where('phone', $clean)
            ->orWhere('phone', '0' . $clean)
            ->orWhere('phone', '91' . $clean)
            ->orWhere('phone', '+91' . $clean)
            ->first();
    }

    // Dynamic Avatar Generator
    public function getAvatarUrlAttribute(): string
    {
        if ($this->avatar) {
            return str_starts_with($this->avatar, 'http') ? $this->avatar : asset('storage/' . $this->avatar);
        }
        return 'https://api.dicebear.com/7.x/bottts/svg?seed=' . urlencode($this->name);
    }
}