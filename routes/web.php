<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CollegeController;
use App\Http\Controllers\LeadController;

use App\Http\Controllers\Admin\DashboardController as AdminDashboard;
use App\Http\Controllers\Admin\CollegeManagerController as AdminCollege;
use App\Http\Controllers\Admin\LeadManagerController as AdminLead;

use App\Http\Controllers\Admin\CourseManagerController as AdminCourse;


// Admin Panel Routes (Protected by Auth & AdminMiddleware)
Route::prefix('admin')->name('admin.')->middleware(['web'])->group(function () {
    
    // Dashboard Stats
    Route::get('/dashboard', [AdminDashboard::class, 'index'])->name('dashboard');
    
    // Courses CRUD Management
    Route::resource('courses', AdminCourse::class);

    // College CRUD Management
    Route::resource('colleges', AdminCollege::class);
    
    // Leads CRM & Export
    Route::get('/leads', [AdminLead::class, 'index'])->name('leads.index');
    Route::post('/leads/{id}/status', [AdminLead::class, 'updateStatus'])->name('leads.updateStatus');
    Route::get('/leads/export/csv', [AdminLead::class, 'exportCsv'])->name('leads.export');
});

// Public Front-End Routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/colleges', [CollegeController::class, 'regularColleges'])->name('colleges.regular');
Route::get('/online-colleges', [CollegeController::class, 'onlineColleges'])->name('colleges.online');
Route::get('/college/{slug}', [CollegeController::class, 'show'])->name('college.show');

// Static Pages
Route::view('/about-us', 'pages.about')->name('about');
Route::view('/contact-us', 'pages.contact')->name('contact');

// Lead Capture API / Form Submission
Route::post('/lead/submit', [LeadController::class, 'store'])->name('lead.submit');

Route::get('/api/live-search', [HomeController::class, 'liveSearch'])->name('api.liveSearch');

Route::get('/sitemap.xml', function () {
    $colleges = App\Models\College::where('status', true)->get();
    
    $content = view('sitemap', compact('colleges'));
    return response($content, 200)->header('Content-Type', 'text/xml');
});

Route::get('/api/states/{state_id}/cities', function ($state_id) {
    return App\Models\City::where('state_id', $state_id)->where('status', true)->orderBy('name')->get();
});