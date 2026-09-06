<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\SystemSetting;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // Share system settings across all blade templates effortlessly
        View::composer('*', function ($view) {
            $view->with('siteSettings', SystemSetting::getAllCached());
        });
    }
}