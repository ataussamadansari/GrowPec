<?php

use App\Http\Controllers\Admin\BannerManagerController as AdminBanner;
// Public Website Controllers
use App\Http\Controllers\Admin\CollegeManagerController as AdminCollege;
use App\Http\Controllers\Admin\CourseManagerController as AdminCourse;
use App\Http\Controllers\Admin\DashboardController as AdminDashboard;
use App\Http\Controllers\Admin\LeadManagerController as AdminLead;
// Admin Panel Controllers
use App\Http\Controllers\Admin\LocationController as AdminLocation;
use App\Http\Controllers\Admin\MasterSettingController as AdminSettings;
use App\Http\Controllers\Admin\PartnerManagerController as AdminPartner;
use App\Http\Controllers\Admin\SpecializationManagerController as AdminSpecialization;
use App\Http\Controllers\Admin\StreamManagerController as AdminStream;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CollegeController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LeadController;
use App\Http\Middleware\AdminMiddleware;
// Middlewares
use App\Http\Middleware\CheckMaintenanceMode;
use App\Models\City;
// Models for Public JSON APIs
use App\Models\College;
use App\Models\Specialization;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Authentication Routes (Always accessible so Admin is never locked out)
|--------------------------------------------------------------------------
*/
Route::middleware(['web', 'guest'])->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware(['web', 'auth']);

/*
|--------------------------------------------------------------------------
| Public Website Routes (Wrapped with CheckMaintenanceMode)
|--------------------------------------------------------------------------
*/
Route::middleware(['web', CheckMaintenanceMode::class])->group(function () {

    // Home Page
    Route::get('/', [HomeController::class, 'index'])->name('home');

    // Colleges Listing & Details
    Route::get('/colleges', [CollegeController::class, 'regularColleges'])->name('colleges.regular');
    Route::get('/online-colleges', [CollegeController::class, 'onlineColleges'])->name('colleges.online');
    Route::get('/college/{slug}', [CollegeController::class, 'show'])->name('college.show');

    // Static Pages
    Route::view('/about-us', 'pages.about')->name('about');
    Route::view('/contact-us', 'pages.contact')->name('contact');

    // Lead Capture API
    Route::post('/lead/submit', [LeadController::class, 'store'])->name('lead.submit');

    // Live Search & Cascading Dropdowns
    Route::get('/api/live-search', [HomeController::class, 'liveSearch'])->name('api.liveSearch');

    Route::get('/api/states/{state_id}/cities', function ($state_id) {
        return City::where('state_id', $state_id)
            ->where('status', true)
            ->orderBy('name')
            ->get();
    })->name('api.states.cities');

    Route::get('/api/courses/{course_id}/specializations', function ($course_id) {
        return Specialization::where('course_id', $course_id)
            ->where('status', true)
            ->orderBy('name')
            ->get();
    })->name('api.courses.specializations');

    // XML Sitemap
    Route::get('/sitemap.xml', function () {
        $colleges = College::where('status', true)->get();
        $content = view('sitemap', compact('colleges'));

        return response($content, 200)->header('Content-Type', 'text/xml');
    });
});

/*
|--------------------------------------------------------------------------
| Admin Panel Routes (Protected by Auth & AdminMiddleware)
|--------------------------------------------------------------------------
*/
Route::prefix('admin')
    ->name('admin.')
    ->middleware(['web', 'auth', AdminMiddleware::class])
    ->group(function () {

        // Dashboard
        Route::get('/dashboard', [AdminDashboard::class, 'index'])->name('dashboard');

        // Banners Manager
        Route::resource('banners', AdminBanner::class);

        // Partner Universities Marquee Strip
        Route::resource('partners', AdminPartner::class);

        // Master Settings
        Route::get('/settings', [AdminSettings::class, 'index'])->name('settings.index');
        Route::post('/settings', [AdminSettings::class, 'update'])->name('settings.update');

        // Academic Resources
        Route::resource('streams', AdminStream::class);
        Route::resource('courses', AdminCourse::class);
        Route::resource('specializations', AdminSpecialization::class);
        Route::resource('colleges', AdminCollege::class);

        // Locations
        Route::get('/locations', [AdminLocation::class, 'index'])->name('locations.index');
        Route::post('/locations/states', [AdminLocation::class, 'storeState'])->name('locations.state.store');
        Route::put('/locations/states/{id}', [AdminLocation::class, 'updateState'])->name('locations.state.update');
        Route::delete('/locations/states/{id}', [AdminLocation::class, 'destroyState'])->name('locations.state.destroy');

        Route::post('/locations/cities', [AdminLocation::class, 'storeCity'])->name('locations.city.store');
        Route::put('/locations/cities/{id}', [AdminLocation::class, 'updateCity'])->name('locations.city.update');
        Route::delete('/locations/cities/{id}', [AdminLocation::class, 'destroyCity'])->name('locations.city.destroy');

        // Leads CRM
        Route::get('/leads', [AdminLead::class, 'index'])->name('leads.index');
        Route::post('/leads/{id}/status', [AdminLead::class, 'updateStatus'])->name('leads.updateStatus');
        Route::get('/leads/export/csv', [AdminLead::class, 'exportCsv'])->name('leads.export');
    });
