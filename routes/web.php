<?php

use Illuminate\Support\Facades\Route;

// Public Website Controllers
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CollegeController;
use App\Http\Controllers\LeadController;

// Admin Panel Controllers
use App\Http\Controllers\Admin\DashboardController as AdminDashboard;
use App\Http\Controllers\Admin\CollegeManagerController as AdminCollege;
use App\Http\Controllers\Admin\LeadManagerController as AdminLead;
use App\Http\Controllers\Admin\CourseManagerController as AdminCourse;
use App\Http\Controllers\Admin\LocationController as AdminLocation;
use App\Http\Controllers\Admin\StreamManagerController as AdminStream;
use App\Http\Controllers\Admin\SpecializationManagerController as AdminSpecialization;
use App\Http\Controllers\StudentProfileController;

// Middleware
use App\Http\Middleware\AdminMiddleware;

// Models for Public APIs
use App\Models\College;
use App\Models\City;
use App\Models\Specialization;

use App\Http\Controllers\AuthController;

/*
|--------------------------------------------------------------------------
| Authentication Routes (Login & Logout)
|--------------------------------------------------------------------------
*/

// Guest & Logout Routes
Route::middleware(['web', 'guest'])->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware(['web', 'auth']);

/*
|--------------------------------------------------------------------------
| Public Website Routes
|--------------------------------------------------------------------------
*/

Route::post('/api/auth/send-otp', [AuthController::class, 'sendOtp'])->name('api.auth.sendOtp');
Route::post('/api/auth/verify-otp', [AuthController::class, 'verifyOtp'])->name('api.auth.verifyOtp');

// Home Page
Route::get('/', [HomeController::class, 'index'])->name('home');

// Protected Student Profile Route
Route::middleware(['web', 'auth'])->group(function () {
    Route::get('/profile', [StudentProfileController::class, 'index'])->name('student.profile');
    Route::post('/profile', [StudentProfileController::class, 'update'])->name('student.profile.update');
});

// Colleges Listing & Details
Route::get('/colleges', [CollegeController::class, 'regularColleges'])->name('colleges.regular');
Route::get('/online-colleges', [CollegeController::class, 'onlineColleges'])->name('colleges.online');
Route::get('/college/{slug}', [CollegeController::class, 'show'])->name('college.show');

// Static Pages
Route::view('/about-us', 'pages.about')->name('about');
Route::view('/contact-us', 'pages.contact')->name('contact');

// Lead Capture API
Route::post('/lead/submit', [LeadController::class, 'store'])->name('lead.submit');

// Public Search & Cascading Dropdown APIs
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
    $content  = view('sitemap', compact('colleges'));
    return response($content, 200)->header('Content-Type', 'text/xml');
});

/*
|--------------------------------------------------------------------------
| Admin Panel Routes (Protected by auth & AdminMiddleware)
|--------------------------------------------------------------------------
| Requires authenticated user with role: 'super_admin' or 'sub_admin'
*/
Route::prefix('admin')
    ->name('admin.')
    ->middleware(['web', 'auth', AdminMiddleware::class])
    ->group(function () {

        // Dashboard
        Route::get('/dashboard', [AdminDashboard::class, 'index'])->name('dashboard');

        // Academic Resources (Streams, Courses, Specializations, Colleges)
        Route::resource('streams', AdminStream::class);
        Route::resource('courses', AdminCourse::class);
        Route::resource('specializations', AdminSpecialization::class);
        Route::resource('colleges', AdminCollege::class);

        // States & Cities Management
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
