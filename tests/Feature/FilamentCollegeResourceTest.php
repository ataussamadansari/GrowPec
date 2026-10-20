<?php

use App\Filament\Resources\Colleges\Pages\CreateCollege;
use App\Filament\Resources\Colleges\Pages\EditCollege;
use App\Filament\Resources\Colleges\Pages\ListColleges;
use App\Filament\Resources\Colleges\RelationManagers\AccreditationsRelationManager;
use App\Filament\Resources\Colleges\RelationManagers\CareerOutcomesRelationManager;
use App\Filament\Resources\Colleges\RelationManagers\CollegeCoursesRelationManager;
use App\Filament\Resources\Colleges\RelationManagers\CollegeFacilitiesRelationManager;
use App\Filament\Resources\Colleges\RelationManagers\CollegeFaqsRelationManager;
use App\Filament\Resources\Colleges\RelationManagers\GalleryRelationManager;
use App\Filament\Resources\Colleges\RelationManagers\HighlightsRelationManager;
use App\Filament\Resources\Colleges\RelationManagers\PlacementStatsRelationManager;
use App\Filament\Resources\Colleges\RelationManagers\RecruitersRelationManager;
use App\Filament\Resources\Colleges\RelationManagers\ScholarshipsRelationManager;
use App\Models\City;
use App\Models\College;
use App\Models\Course;
use App\Models\State;
use App\Models\Stream;
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

    $this->state = State::create([
        'name' => 'Maharashtra',
        'slug' => 'maharashtra-'.uniqid(),
        'status' => true,
    ]);

    $this->city = City::create([
        'state_id' => $this->state->id,
        'name' => 'Mumbai',
        'slug' => 'mumbai-'.uniqid(),
        'status' => true,
    ]);
});

function makeCollegeForTesting(array $attributes = []): College
{
    return College::create(array_merge([
        'name' => 'National Technology Institute',
        'slug' => 'national-tech-inst-'.uniqid(),
        'college_mode' => 'regular',
        'state' => 'Maharashtra',
        'city' => 'Mumbai',
        'status' => true,
        'rating' => 4.6,
    ], $attributes));
}

test('guest is redirected to login from college admin pages', function (string $url) {
    $this->get($url)->assertRedirect('/admin/login');
})->with([
    '/admin/colleges',
    '/admin/colleges/create',
]);

test('student is forbidden from accessing college admin pages', function (string $url) {
    $this->actingAs($this->student)->get($url)->assertForbidden();
})->with([
    '/admin/colleges',
    '/admin/colleges/create',
]);

test('super admin can view college index and create pages', function () {
    $this->actingAs($this->admin)->get('/admin/colleges')->assertSuccessful()->assertSee('Colleges');
    $this->actingAs($this->admin)->get('/admin/colleges/create')->assertSuccessful();
});

test('college can be listed and created via livewire', function () {
    $this->actingAs($this->admin);

    Livewire::test(ListColleges::class)->assertSuccessful();

    $uniqueSlug = 'apex-tech-university-'.uniqid();

    Livewire::test(CreateCollege::class)
        ->fillForm([
            'name' => 'Apex Tech University',
            'slug' => $uniqueSlug,
            'college_mode' => 'regular',
            'state_id' => $this->state->id,
            'city_id' => $this->city->id,
            'college_type' => 'Private',
            'rating' => 4.5,
            'status' => true,
        ])
        ->call('create')
        ->assertHasNoFormErrors();

    $this->assertDatabaseHas('colleges', [
        'name' => 'Apex Tech University',
        'slug' => $uniqueSlug,
        'college_mode' => 'regular',
        'city_id' => $this->city->id,
    ]);
});

test('college can be edited via livewire', function () {
    $this->actingAs($this->admin);

    $college = makeCollegeForTesting();

    Livewire::test(EditCollege::class, [
        'record' => $college->getKey(),
    ])
        ->assertSuccessful()
        ->fillForm([
            'short_name' => 'NTI Mumbai',
            'highest_package' => '42 LPA',
            'average_package' => '10.5 LPA',
        ])
        ->call('save')
        ->assertHasNoFormErrors();

    $this->assertDatabaseHas('colleges', [
        'id' => $college->id,
        'short_name' => 'NTI Mumbai',
        'highest_package' => '42 LPA',
    ]);
});

test('college course relation manager creates course offerings', function () {
    $this->actingAs($this->admin);

    $college = makeCollegeForTesting();

    $stream = Stream::create([
        'name' => 'Engineering-'.uniqid(),
        'slug' => 'eng-'.uniqid(),
    ]);

    $course = Course::create([
        'stream_id' => $stream->id,
        'name' => 'B.Tech Artificial Intelligence',
        'slug' => 'btech-ai-'.uniqid(),
        'level' => 'UG',
        'degree_type' => 'Degree',
        'duration' => '4 Years',
    ]);

    Livewire::test(CollegeCoursesRelationManager::class, [
        'ownerRecord' => $college,
        'pageClass' => EditCollege::class,
    ])
        ->assertSuccessful()
        ->callTableAction('create', data: [
            'course_id' => $course->id,
            'specialization' => 'Artificial Intelligence & Data Science',
            'fee_amount' => 180000,
            'fee_type' => 'per_year',
            'duration' => '4 Years',
            'status' => true,
        ])
        ->assertHasNoTableActionErrors();

    $this->assertDatabaseHas('college_courses', [
        'college_id' => $college->id,
        'course_id' => $course->id,
        'specialization' => 'Artificial Intelligence & Data Science',
        'fee_amount' => 180000,
    ]);
});

test('accreditations relation manager creates accreditation records', function () {
    $this->actingAs($this->admin);

    $college = makeCollegeForTesting();

    Livewire::test(AccreditationsRelationManager::class, [
        'ownerRecord' => $college,
        'pageClass' => EditCollege::class,
    ])
        ->assertSuccessful()
        ->callTableAction('create', data: [
            'authority' => 'NAAC',
            'accreditation' => 'National Assessment and Accreditation Council',
            'grade' => 'A++',
            'rank' => 'Grade A++',
            'year' => 2025,
            'status' => true,
        ])
        ->assertHasNoTableActionErrors();

    $this->assertDatabaseHas('college_accreditations', [
        'college_id' => $college->id,
        'authority' => 'NAAC',
        'grade' => 'A++',
    ]);
});

test('facilities relation manager creates campus facility items', function () {
    $this->actingAs($this->admin);

    $college = makeCollegeForTesting();

    Livewire::test(CollegeFacilitiesRelationManager::class, [
        'ownerRecord' => $college,
        'pageClass' => EditCollege::class,
    ])
        ->assertSuccessful()
        ->callTableAction('create', data: [
            'name' => 'Modern Supercomputing Lab',
            'icon' => 'fa-laptop-code',
            'description' => 'Equipped with NVIDIA A100 GPU clusters.',
            'status' => true,
        ])
        ->assertHasNoTableActionErrors();

    $this->assertDatabaseHas('college_facilities', [
        'college_id' => $college->id,
        'name' => 'Modern Supercomputing Lab',
    ]);
});

test('placement stats relation manager creates placement metrics', function () {
    $this->actingAs($this->admin);

    $college = makeCollegeForTesting();

    Livewire::test(PlacementStatsRelationManager::class, [
        'ownerRecord' => $college,
        'pageClass' => EditCollege::class,
    ])
        ->assertSuccessful()
        ->callTableAction('create', data: [
            'year' => 2025,
            'label' => 'Highest International Package',
            'value' => '68 LPA',
            'placement_percentage' => 97,
            'status' => true,
        ])
        ->assertHasNoTableActionErrors();

    $this->assertDatabaseHas('college_placement_stats', [
        'college_id' => $college->id,
        'label' => 'Highest International Package',
        'value' => '68 LPA',
    ]);
});

test('career outcomes relation manager creates career outcome paths', function () {
    $this->actingAs($this->admin);

    $college = makeCollegeForTesting();

    Livewire::test(CareerOutcomesRelationManager::class, [
        'ownerRecord' => $college,
        'pageClass' => EditCollege::class,
    ])
        ->assertSuccessful()
        ->callTableAction('create', data: [
            'career_role' => 'Cloud Solutions Architect',
            'industry' => 'Cloud & IT Services',
            'average_salary' => '18.5 LPA',
            'status' => true,
        ])
        ->assertHasNoTableActionErrors();

    $this->assertDatabaseHas('college_career_outcomes', [
        'college_id' => $college->id,
        'career_role' => 'Cloud Solutions Architect',
        'average_salary' => '18.5 LPA',
    ]);
});

test('scholarships relation manager creates scholarship awards', function () {
    $this->actingAs($this->admin);

    $college = makeCollegeForTesting();

    Livewire::test(ScholarshipsRelationManager::class, [
        'ownerRecord' => $college,
        'pageClass' => EditCollege::class,
    ])
        ->assertSuccessful()
        ->callTableAction('create', data: [
            'name' => 'Founder Merit Scholarship',
            'amount_label' => '100% Tuition Waiver',
            'amount' => 200000,
            'eligibility' => 'Top 1% rank in national entrance',
            'status' => true,
        ])
        ->assertHasNoTableActionErrors();

    $this->assertDatabaseHas('college_scholarships', [
        'college_id' => $college->id,
        'name' => 'Founder Merit Scholarship',
    ]);
});

test('college faqs relation manager creates institutional questions', function () {
    $this->actingAs($this->admin);

    $college = makeCollegeForTesting();

    Livewire::test(CollegeFaqsRelationManager::class, [
        'ownerRecord' => $college,
        'pageClass' => EditCollege::class,
    ])
        ->assertSuccessful()
        ->callTableAction('create', data: [
            'question' => 'Are on-campus hostel facilities mandatory for first-year students?',
            'answer' => 'No, hostel accommodation is optional and subject to availability.',
            'sort_order' => 1,
            'status' => true,
        ])
        ->assertHasNoTableActionErrors();

    $this->assertDatabaseHas('college_faqs', [
        'college_id' => $college->id,
        'question' => 'Are on-campus hostel facilities mandatory for first-year students?',
    ]);
});

test('gallery relation manager creates photo entries', function () {
    Storage::fake('public');
    $this->actingAs($this->admin);

    $college = makeCollegeForTesting();
    $file = UploadedFile::fake()->create('campus_auditorium.jpg', 150, 'image/jpeg');

    Livewire::test(GalleryRelationManager::class, [
        'ownerRecord' => $college,
        'pageClass' => EditCollege::class,
    ])
        ->assertSuccessful()
        ->callTableAction('create', data: [
            'title' => 'Main Auditorium Hall',
            'image' => $file,
            'category' => 'Infrastructure',
            'status' => true,
        ])
        ->assertHasNoTableActionErrors();

    $this->assertDatabaseHas('college_gallery', [
        'college_id' => $college->id,
        'title' => 'Main Auditorium Hall',
        'category' => 'Infrastructure',
    ]);
});

test('highlights relation manager creates key highlight cards', function () {
    $this->actingAs($this->admin);

    $college = makeCollegeForTesting();

    Livewire::test(HighlightsRelationManager::class, [
        'ownerRecord' => $college,
        'pageClass' => EditCollege::class,
    ])
        ->assertSuccessful()
        ->callTableAction('create', data: [
            'title' => 'NIRF 2025 Ranking',
            'value' => 'Ranked #45 Pan India',
            'icon' => 'bi-award-fill',
            'status' => true,
        ])
        ->assertHasNoTableActionErrors();

    $this->assertDatabaseHas('college_highlights', [
        'college_id' => $college->id,
        'title' => 'NIRF 2025 Ranking',
        'value' => 'Ranked #45 Pan India',
    ]);
});

test('recruiters relation manager creates corporate recruiter entries', function () {
    $this->actingAs($this->admin);

    $college = makeCollegeForTesting();

    Livewire::test(RecruitersRelationManager::class, [
        'ownerRecord' => $college,
        'pageClass' => EditCollege::class,
    ])
        ->assertSuccessful()
        ->callTableAction('create', data: [
            'name' => 'Google Inc',
            'description' => 'Annual Campus Recruitment Drive',
            'status' => true,
        ])
        ->assertHasNoTableActionErrors();

    $this->assertDatabaseHas('college_recruiters', [
        'college_id' => $college->id,
        'name' => 'Google Inc',
    ]);
});

test('college model supports parent and child online college relationships and fillable parent_college_id', function () {
    $parent = makeCollegeForTesting([
        'name' => 'Apex Regular University',
        'slug' => 'apex-regular-university-'.uniqid(),
        'college_mode' => 'regular',
    ]);

    $onlineChild = College::create([
        'parent_college_id' => $parent->id,
        'name' => 'Apex Online University',
        'slug' => 'apex-online-university-'.uniqid(),
        'college_mode' => 'online',
        'state_id' => $this->state->id,
        'city_id' => $this->city->id,
        'status' => true,
    ]);

    expect($onlineChild->parentCollege)->not->toBeNull()
        ->and($onlineChild->parentCollege->id)->toBe($parent->id)
        ->and($parent->childColleges)->toHaveCount(1)
        ->and($parent->onlineCampuses)->toHaveCount(1)
        ->and($parent->onlineCampuses->first()->id)->toBe($onlineChild->id);
});
