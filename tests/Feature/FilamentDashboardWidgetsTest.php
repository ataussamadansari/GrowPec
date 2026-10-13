<?php

use App\Filament\Widgets\LatestLeadsWidget;
use App\Filament\Widgets\PendingReviewsWidget;
use App\Filament\Widgets\StatsOverviewWidget;
use App\Models\College;
use App\Models\CollegeReview;
use App\Models\Course;
use App\Models\Lead;
use App\Models\Stream;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\Livewire;

beforeEach(function () {
    $this->admin = User::factory()->create([
        'role' => 'super_admin',
        'password' => Hash::make('secret123'),
    ]);

    $this->subAdmin = User::factory()->create([
        'role' => 'sub_admin',
    ]);

    $this->student = User::factory()->create([
        'role' => 'student',
    ]);
});

function makeCollege(array $attributes = []): College
{
    return College::create(array_merge([
        'name' => 'National Technology Institute',
        'slug' => 'national-tech-'.uniqid(),
        'college_mode' => 'regular',
        'state' => 'Maharashtra',
        'city' => 'Mumbai',
        'status' => true,
        'rating' => 4.6,
    ], $attributes));
}

function makeCourse(array $attributes = []): Course
{
    $stream = Stream::firstOrCreate(
        ['name' => 'Engineering Stream Test'],
        ['slug' => 'engineering-stream-test']
    );

    return Course::create(array_merge([
        'stream_id' => $stream->id,
        'name' => 'Computer Science Course',
        'slug' => 'cs-course-'.uniqid(),
        'level' => 'UG',
        'degree_type' => 'Degree',
        'duration' => '4 Years',
    ], $attributes));
}

function makeReview(array $attributes = []): CollegeReview
{
    $collegeId = $attributes['college_id'] ?? null;
    if (! $collegeId) {
        $college = makeCollege();
        $collegeId = $college->id;
    }

    return CollegeReview::create(array_merge([
        'college_id' => $collegeId,
        'reviewer_name' => 'Test Reviewer',
        'email' => 'reviewer@example.com',
        'course' => 'B.Tech IT',
        'rating' => 5,
        'review' => 'Great campus and faculty.',
        'status' => 'pending',
        'is_verified' => false,
    ], $attributes));
}

test('unauthenticated guest is redirected from filament dashboard to login', function () {
    $this->get('/admin')
        ->assertRedirect('/admin/login');
});

test('student is forbidden from accessing filament dashboard', function () {
    $this->actingAs($this->student)
        ->get('/admin')
        ->assertForbidden();
});

test('legacy admin dashboard url redirects to filament dashboard', function () {
    $this->actingAs($this->admin)
        ->get('/admin/dashboard')
        ->assertRedirect('/admin');
});

test('super admin can access filament dashboard with 200 ok', function () {
    $this->actingAs($this->admin)
        ->get('/admin')
        ->assertSuccessful()
        ->assertSee('GrowPec Administration')
        ->assertSee('Dashboard');
});

test('sub admin can access filament dashboard with 200 ok', function () {
    $this->actingAs($this->subAdmin)
        ->get('/admin')
        ->assertSuccessful()
        ->assertSee('GrowPec Administration')
        ->assertSee('Dashboard');
});

test('login route redirects to filament admin login', function () {
    $this->get('/login')
        ->assertRedirect('/admin/login');
});

test('stats overview widget renders accurate kpis on filament dashboard', function () {
    makeCollege(['college_mode' => 'regular']);
    makeCollege(['college_mode' => 'regular']);
    makeCollege(['college_mode' => 'online']);

    makeCourse(['name' => 'Course 1']);
    makeCourse(['name' => 'Course 2']);
    makeCourse(['name' => 'Course 3']);

    Lead::create([
        'name' => 'Lead Today 1',
        'phone' => '9999911111',
        'email' => 'lead1@example.com',
        'status' => 'new',
    ]);
    Lead::create([
        'name' => 'Lead Today 2',
        'phone' => '9999922222',
        'email' => 'lead2@example.com',
        'status' => 'new',
    ]);
    $leadOlder = Lead::create([
        'name' => 'Lead Older',
        'phone' => '9999933333',
        'email' => 'lead3@example.com',
        'status' => 'contacted',
    ]);
    Lead::where('id', $leadOlder->id)->update(['created_at' => now()->subDays(3)]);

    $college = College::first();
    makeReview([
        'college_id' => $college->id,
        'status' => 'pending',
    ]);
    makeReview([
        'college_id' => $college->id,
        'status' => 'pending',
    ]);
    makeReview([
        'college_id' => $college->id,
        'status' => 'approved',
    ]);

    $this->actingAs($this->admin);

    Livewire::test(StatsOverviewWidget::class)
        ->assertSuccessful()
        ->assertSee('Total Colleges')
        ->assertSee('3')
        ->assertSee('2 Regular • 1 Online')
        ->assertSee('Total Leads')
        ->assertSee('3')
        ->assertSee('+2 received today')
        ->assertSee('Pending Reviews')
        ->assertSee('2')
        ->assertSee('Awaiting moderation')
        ->assertSee('Academic Courses')
        ->assertSee('3');
});

test('stats overview widget shows all reviews moderated when no pending reviews exist', function () {
    $college = makeCollege();
    makeReview([
        'college_id' => $college->id,
        'status' => 'approved',
    ]);

    $this->actingAs($this->admin);

    Livewire::test(StatsOverviewWidget::class)
        ->assertSuccessful()
        ->assertSee('All reviews moderated');
});

test('latest leads widget displays recent student inquiries in table', function () {
    $college = makeCollege(['name' => 'IIT Bombay']);
    $course = makeCourse(['name' => 'Computer Science']);

    Lead::create([
        'name' => 'Aarav Sharma',
        'phone' => '9876543210',
        'email' => 'aarav@example.com',
        'college_id' => $college->id,
        'course_id' => $course->id,
        'status' => 'new',
    ]);

    $this->actingAs($this->admin);

    Livewire::test(LatestLeadsWidget::class)
        ->assertSuccessful()
        ->assertSee('Recent Student Enquiries')
        ->assertSee('Aarav Sharma')
        ->assertSee('9876543210')
        ->assertSee('IIT Bombay');
});

test('pending reviews widget displays pending reviews and handles 1-click approve action', function () {
    $college = makeCollege(['name' => 'BITS Pilani']);

    $review = makeReview([
        'college_id' => $college->id,
        'reviewer_name' => 'Priya Patel',
        'review' => 'Top Engineering Campus with modern labs.',
        'rating' => 5,
        'status' => 'pending',
        'is_verified' => false,
    ]);

    $this->actingAs($this->admin);

    Livewire::test(PendingReviewsWidget::class)
        ->assertSuccessful()
        ->assertSee('Reviews Awaiting Moderation')
        ->assertSee('Priya Patel')
        ->assertSee('BITS Pilani')
        ->callTableAction('approve', $review);

    $this->assertDatabaseHas('college_reviews', [
        'id' => $review->id,
        'status' => 'approved',
        'is_verified' => true,
    ]);
});

test('pending reviews widget handles 1-click reject action', function () {
    $college = makeCollege(['name' => 'Delhi University']);

    $review = makeReview([
        'college_id' => $college->id,
        'reviewer_name' => 'Spam Submitter',
        'review' => 'Spam Content Here for testing.',
        'rating' => 1,
        'status' => 'pending',
        'is_verified' => false,
    ]);

    $this->actingAs($this->admin);

    Livewire::test(PendingReviewsWidget::class)
        ->assertSuccessful()
        ->assertSee('Reviews Awaiting Moderation')
        ->assertSee('Spam Submitter')
        ->callTableAction('reject', $review);

    $this->assertDatabaseHas('college_reviews', [
        'id' => $review->id,
        'status' => 'rejected',
    ]);
});
