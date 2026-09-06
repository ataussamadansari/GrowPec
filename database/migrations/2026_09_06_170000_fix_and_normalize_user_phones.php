<?php

use Illuminate\Database\Migrations\Migration;
use App\Models\User;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Group users by normalized 10-digit phone
        $users = User::all();
        $processed = [];

        foreach ($users as $user) {
            if (!$user->phone) continue;

            $cleanPhone = User::sanitizePhone($user->phone);

            if (isset($processed[$cleanPhone])) {
                $previousUser = $processed[$cleanPhone];

                // Check which user is the real user vs dummy user
                $isCurrentDummy = str_ends_with($user->email ?? '', '@growpec.local') || $user->name === 'Student';
                $isPrevDummy    = str_ends_with($previousUser->email ?? '', '@growpec.local') || $previousUser->name === 'Student';

                if ($isCurrentDummy && !$isPrevDummy) {
                    // Delete current duplicate
                    $user->delete();
                    $previousUser->update(['phone' => $cleanPhone]);
                } elseif (!$isCurrentDummy && $isPrevDummy) {
                    // Delete previous duplicate and keep current
                    $previousUser->delete();
                    $user->update(['phone' => $cleanPhone]);
                    $processed[$cleanPhone] = $user;
                } else {
                    // Keep the older real user
                    $user->delete();
                    $previousUser->update(['phone' => $cleanPhone]);
                }
            } else {
                $user->update(['phone' => $cleanPhone]);
                $processed[$cleanPhone] = $user;
            }
        }
    }

    public function down(): void
    {
        // No reversal needed
    }
};