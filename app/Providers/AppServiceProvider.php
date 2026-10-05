<?php

namespace App\Providers;

use App\Models\CenterLogin;
use App\Models\College;
use App\Models\Course;
use App\Models\SystemSetting;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // Share system settings, active center logins, courses, and colleges across all blade templates
        View::composer('*', function ($view) {
            $view->with([
                'siteSettings' => SystemSetting::getAllCached(),
                'activeCenterLogins' => CenterLogin::getAllCached(),
                'contactPhones' => SystemSetting::getPhones(),
                'contactEmails' => SystemSetting::getEmails(),
                'contactAddresses' => SystemSetting::getAddresses(),
                'globalCourses' => Cache::remember('global_courses_list', 3600, fn () => Course::orderBy('name')->get(['id', 'name'])),
                'globalColleges' => Cache::remember('global_colleges_list', 3600, fn () => College::where('status', true)->orderBy('name')->get(['id', 'name', 'college_mode'])),
            ]);
        });
    }
}
