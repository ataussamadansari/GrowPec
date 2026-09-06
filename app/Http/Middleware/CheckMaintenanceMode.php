<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\SystemSetting;

class CheckMaintenanceMode
{
    public function handle(Request $request, Closure $next)
    {
        // Check if maintenance mode is enabled in system settings
        $isMaintenance = (string) SystemSetting::get('features.maintenance_mode', '0') === '1';

        if ($isMaintenance) {
            // 1. Allow Admins (Super Admin & Sub Admin)
            if (Auth::check() && in_array(Auth::user()->role, ['super_admin', 'sub_admin'])) {
                return $next($request);
            }

            // 2. Allow Admin panel routes and Auth routes (so admin can log in)
            if ($request->is('admin*') || $request->is('login*') || $request->is('logout*')) {
                return $next($request);
            }

            // 3. Show 503 Maintenance Page to regular public visitors
            $siteSettings = SystemSetting::getAllCached();
            return response()->view('errors.maintenance', compact('siteSettings'), 503);
        }

        return $next($request);
    }
}