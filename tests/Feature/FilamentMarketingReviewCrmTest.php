<?php

use App\Filament\Pages\ManageSettings;
use App\Filament\Resources\Banners\Pages\CreateBanner;
use App\Filament\Resources\Banners\Pages\ListBanners;
use App\Filament\Resources\CenterLogins\Pages\CreateCenterLogin;
use App\Filament\Resources\CenterLogins\Pages\ListCenterLogins;
use App\Filament\Resources\CollegeReviews\Pages\ListCollegeReviews;
use App\Filament\Resources\LeadershipMessages\Pages\CreateLeadershipMessage;
use App\Filament\Resources\LeadershipMessages\Pages\ListLeadershipMessages;
use App\Filament\Resources\Leads\Pages\CreateLead;
use App\Filament\Resources\Leads\Pages\ListLeads;
use App\Filament\Resources\Partners\Pages\CreatePartner;
use App\Filament\Resources\Partners\Pages\ListPartners;
use App\Models\CenterLogin;
use App\Models\College;
use App\Models\CollegeReview;
use App\Models\SystemSetting;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;

beforeEach(function () {
    $this->admin = User::factory()->create([
        'role' => 'super_admin',
    ]);

    $this->student = User::factory()->create([
        'role' => 'student',
    ]);
});

test('guest is redirected to login from crm, review, and marketing pages', function (string $url) {
    $this->get($url)->assertRedirect('/admin/login');
})->with([
    '/admin/leads',
    '/admin/college-reviews',
    '/admin/banners',
    '/admin/partners',
    '/admin/leadership-messages',
    '/admin/center-logins',
    '/admin/manage-settings',
]);

test('student is forbidden from accessing crm, review, and marketing pages', function (string $url) {
    $this->actingAs($this->student)->get($url)->assertForbidden();
})->with([
    '/admin/leads',
    '/admin/college-reviews',
    '/admin/banners',
    '/admin/partners',
    '/admin/leadership-messages',
    '/admin/center-logins',
    '/admin/manage-settings',
]);

test('super admin can view all crm, review, and marketing pages', function () {
    $this->actingAs($this->admin)->get('/admin/leads')->assertSuccessful()->assertSee('Leads');
    $this->actingAs($this->admin)->get('/admin/college-reviews')->assertSuccessful()->assertSee('College Reviews');
    $this->actingAs($this->admin)->get('/admin/banners')->assertSuccessful()->assertSee('Hero Banners');
    $this->actingAs($this->admin)->get('/admin/partners')->assertSuccessful()->assertSee('Partners / Affiliates');
    $this->actingAs($this->admin)->get('/admin/leadership-messages')->assertSuccessful()->assertSee('Leadership Messages');
    $this->actingAs($this->admin)->get('/admin/center-logins')->assertSuccessful()->assertSee('Center Logins');
    $this->actingAs($this->admin)->get('/admin/manage-settings')->assertSuccessful()->assertSee('System & Marketing Settings');
});

function makeTestCollege(array $attributes = []): College
{
    return College::create(array_merge([
        'name' => 'Review Test Institute',
        'slug' => 'review-test-institute-'.uniqid(),
        'college_mode' => 'regular',
        'state' => 'Karnataka',
        'city' => 'Bengaluru',
        'status' => true,
        'rating' => 4.5,
    ], $attributes));
}

test('college reviews can be listed and approved via 1-click action', function () {
    $this->actingAs($this->admin);

    $college = makeTestCollege();

    $review = CollegeReview::create([
        'college_id' => $college->id,
        'reviewer_name' => 'Amit Sharma',
        'email' => 'amit@example.com',
        'course' => 'B.Tech IT',
        'rating' => 5,
        'review' => 'Excellent campus and helpful faculty.',
        'status' => 'pending',
        'is_verified' => false,
    ]);

    Livewire::test(ListCollegeReviews::class)
        ->assertSuccessful()
        ->callTableAction('approve', $review);

    $review->refresh();
    expect($review->status)->toBe('approved')
        ->and($review->is_verified)->toBeTrue();
});

test('college reviews can be rejected via 1-click action', function () {
    $this->actingAs($this->admin);

    $college = makeTestCollege();

    $review = CollegeReview::create([
        'college_id' => $college->id,
        'reviewer_name' => 'Spam Bot',
        'email' => 'spam@example.com',
        'course' => 'Spam Course',
        'rating' => 1,
        'review' => 'Inappropriate promo content.',
        'status' => 'pending',
        'is_verified' => false,
    ]);

    Livewire::test(ListCollegeReviews::class)
        ->assertSuccessful()
        ->callTableAction('reject', $review);

    $review->refresh();
    expect($review->status)->toBe('rejected');
});

test('lead can be listed and created via livewire', function () {
    $this->actingAs($this->admin);

    $college = makeTestCollege();

    Livewire::test(ListLeads::class)->assertSuccessful();

    Livewire::test(CreateLead::class)
        ->fillForm([
            'college_id' => $college->id,
            'name' => 'Priya Verma',
            'phone' => '9876543210',
            'email' => 'priya@example.com',
            'city' => 'Delhi',
            'state' => 'Delhi',
            'source' => 'Website',
            'status' => 'new',
            'notes' => 'Looking for computer science admissions.',
        ])
        ->call('create')
        ->assertHasNoFormErrors();

    $this->assertDatabaseHas('leads', [
        'name' => 'Priya Verma',
        'phone' => '9876543210',
        'status' => 'new',
    ]);
});

test('banner resource can be created via livewire', function () {
    Storage::fake('public');
    $this->actingAs($this->admin);

    Livewire::test(ListBanners::class)->assertSuccessful();

    $file = UploadedFile::fake()->create('banner_hero.jpg', 100, 'image/jpeg');

    Livewire::test(CreateBanner::class)
        ->fillForm([
            'title' => 'Admissions Open 2026',
            'image' => $file,
            'sort_order' => 1,
            'status' => true,
        ])
        ->call('create')
        ->assertHasNoFormErrors();

    $this->assertDatabaseHas('banners', [
        'title' => 'Admissions Open 2026',
        'sort_order' => 1,
        'status' => true,
    ]);
});

test('partner resource can be created via livewire', function () {
    $this->actingAs($this->admin);

    Livewire::test(ListPartners::class)->assertSuccessful();

    Livewire::test(CreatePartner::class)
        ->fillForm([
            'name' => 'IIT Kharagpur Partner',
            'sort_order' => 5,
            'status' => true,
        ])
        ->call('create')
        ->assertHasNoFormErrors();

    $this->assertDatabaseHas('partners', [
        'name' => 'IIT Kharagpur Partner',
        'sort_order' => 5,
        'status' => true,
    ]);
});

test('leadership message can be created via livewire', function () {
    $this->actingAs($this->admin);

    Livewire::test(ListLeadershipMessages::class)->assertSuccessful();

    Livewire::test(CreateLeadershipMessage::class)
        ->fillForm([
            'role' => 'director',
            'name' => 'Dr. R. K. Sharma',
            'designation' => 'Managing Director',
            'message' => 'Welcome to our platform. We empower students across the nation.',
            'status' => true,
        ])
        ->call('create')
        ->assertHasNoFormErrors();

    $this->assertDatabaseHas('leadership_messages', [
        'role' => 'director',
        'name' => 'Dr. R. K. Sharma',
        'designation' => 'Managing Director',
        'status' => true,
    ]);
});

test('center login can be created and busts cache', function () {
    $this->actingAs($this->admin);

    Livewire::test(ListCenterLogins::class)->assertSuccessful();

    Livewire::test(CreateCenterLogin::class)
        ->fillForm([
            'title' => 'Student Portal Entrance',
            'url' => 'https://students.growpec.com/login',
            'index' => 1,
            'is_active' => true,
        ])
        ->call('create')
        ->assertHasNoFormErrors();

    $this->assertDatabaseHas('center_logins', [
        'title' => 'Student Portal Entrance',
        'url' => 'https://students.growpec.com/login',
        'is_active' => true,
    ]);

    expect(CenterLogin::getAllCached()->pluck('title'))->toContain('Student Portal Entrance');
});

test('manage settings page updates system settings', function () {
    $this->actingAs($this->admin);

    Livewire::test(ManageSettings::class)
        ->assertSuccessful()
        ->fillForm([
            'general_site_name' => 'GrowPec EdTech',
            'general_tagline' => 'Shape Your Future With GrowPec',
            'general_support_phone' => '+91 91234 56789',
            'general_support_email' => 'contact@growpec.com',
            'social_facebook' => 'https://facebook.com/growpecofficial',
        ])
        ->call('save')
        ->assertHasNoFormErrors();

    expect(SystemSetting::get('general.site_name'))->toBe('GrowPec EdTech')
        ->and(SystemSetting::get('general.tagline'))->toBe('Shape Your Future With GrowPec')
        ->and(SystemSetting::get('general.support_phone'))->toBe('+91 91234 56789')
        ->and(SystemSetting::get('general.support_email'))->toBe('contact@growpec.com')
        ->and(SystemSetting::get('social.facebook'))->toBe('https://facebook.com/growpecofficial');
});
