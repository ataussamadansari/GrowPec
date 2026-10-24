<?php

// Public Website Controllers
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CollegeComparisonController;
use App\Http\Controllers\CollegeController;
use App\Http\Controllers\CollegeReviewController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LeadController;
use App\Http\Controllers\LeadershipMessagePageController;
use App\Http\Controllers\WebsiteReviewController;
use App\Http\Middleware\AdminMiddleware;
// Middlewares
use App\Http\Middleware\CheckMaintenanceMode;
use App\Models\City;
// Models for Public JSON APIs
use App\Models\College;
use App\Models\Specialization;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Authentication Routes (Always accessible so Admin is never locked out)
|--------------------------------------------------------------------------
*/
Route::redirect('/login', '/admin/login')->name('login');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware(['web', 'auth']);

/*
|--------------------------------------------------------------------------
| Public Website Routes (Wrapped with CheckMaintenanceMode)
|--------------------------------------------------------------------------
*/
Route::middleware(['web', CheckMaintenanceMode::class])->group(function () {

    // Home Page
    Route::get('/', [HomeController::class, 'index'])->name('home');

    // Colleges Listing, Comparison & Details
    Route::get('/colleges', [CollegeController::class, 'regularColleges'])->name('colleges.regular');
    Route::get('/online-colleges', [CollegeController::class, 'onlineColleges'])->name('colleges.online');
    Route::get('/online-regular-colleges', [CollegeController::class, 'orColleges'])->name('colleges.onlineregular');
    Route::get('/compare', [CollegeComparisonController::class, 'index'])->name('colleges.compare');
    Route::get('/college/{slug}', [CollegeController::class, 'show'])->name('college.show');
    Route::post('/college/{slug}/reviews', [CollegeReviewController::class, 'store'])
        ->name('college.reviews.store')
        ->middleware('throttle:5,60');
    Route::post('/website-reviews', [WebsiteReviewController::class, 'store'])
        ->name('website.reviews.store')
        ->middleware('throttle:5,60');
    Route::get('/reviews/write', function (Request $request) {
        $params = ['write_review' => 1];
        if ($request->filled('rating')) {
            $params['rating'] = (int) $request->input('rating');
        }

        return redirect()->to(route('home', $params).'#growpecReviewsSection');
    })->name('website.reviews.write');
    Route::get('/rate-us', function (Request $request) {
        $params = ['write_review' => 1];
        if ($request->filled('rating')) {
            $params['rating'] = (int) $request->input('rating');
        }

        return redirect()->to(route('home', $params).'#growpecReviewsSection');
    })->name('website.reviews.rate');
    Route::get('/reviews', function (Request $request) {
        $params = [];
        if ($request->has('write') || $request->has('write_review') || $request->has('rate')) {
            $params['write_review'] = 1;
        }
        if ($request->filled('rating')) {
            $params['rating'] = (int) $request->input('rating');
        }

        return redirect()->to(route('home', $params).'#growpecReviewsSection');
    })->name('website.reviews.index');

    // Static Pages
    Route::get('/leadership-message/{leadershipMessage}', [LeadershipMessagePageController::class, 'show'])
        ->name('leadership-messages.show');
    Route::get('/about-us', [LeadershipMessagePageController::class, 'about'])->name('about');
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

    // 404 Error Page Preview
    Route::get('/404', function () {
        abort(404);
    })->name('error.404');
});

/*
|--------------------------------------------------------------------------
| Admin Panel Redirect Routes (Protected by Auth & AdminMiddleware)
|--------------------------------------------------------------------------
*/
Route::prefix('admin')
    ->name('admin.')
    ->middleware(['web', 'auth', AdminMiddleware::class])
    ->group(function () {
        // Dashboard Redirect to modern Filament Admin Panel at /admin
        Route::get('/dashboard', fn () => redirect('/admin'))->name('dashboard');
    });
