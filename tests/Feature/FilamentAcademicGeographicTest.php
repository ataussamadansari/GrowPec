<?php

use App\Filament\Resources\Cities\Pages\CreateCity;
use App\Filament\Resources\Cities\Pages\ListCities;
use App\Filament\Resources\Courses\Pages\CreateCourse;
use App\Filament\Resources\Courses\Pages\ListCourses;
use App\Filament\Resources\Specializations\Pages\CreateSpecialization;
use App\Filament\Resources\Specializations\Pages\ListSpecializations;
use App\Filament\Resources\States\Pages\CreateState;
use App\Filament\Resources\States\Pages\ListStates;
use App\Filament\Resources\Streams\Pages\CreateStream;
use App\Filament\Resources\Streams\Pages\ListStreams;
use App\Models\City;
use App\Models\Course;
use App\Models\State;
use App\Models\Stream;
use App\Models\User;
use Livewire\Livewire;

beforeEach(function () {
    $this->admin = User::factory()->create([
        'role' => 'super_admin',
    ]);

    $this->student = User::factory()->create([
        'role' => 'student',
    ]);
});

test('guest is redirected to login from geographic and academic pages', function (string $url) {
    $response = $this->get($url);

    $response->assertRedirect('/admin/login');
})->with([
    '/admin/states',
    '/admin/cities',
    '/admin/streams',
    '/admin/courses',
    '/admin/specializations',
]);

test('student is forbidden from accessing geographic and academic pages', function (string $url) {
    $response = $this->actingAs($this->student)->get($url);

    $response->assertForbidden();
})->with([
    '/admin/states',
    '/admin/cities',
    '/admin/streams',
    '/admin/courses',
    '/admin/specializations',
]);

test('super admin can view geographic resources index and create pages', function () {
    $this->actingAs($this->admin)->get('/admin/states')->assertSuccessful()->assertSee('States');
    $this->actingAs($this->admin)->get('/admin/states/create')->assertSuccessful();

    $this->actingAs($this->admin)->get('/admin/cities')->assertSuccessful()->assertSee('Cities');
    $this->actingAs($this->admin)->get('/admin/cities/create')->assertSuccessful();
});

test('super admin can view academic resources index and create pages', function () {
    $this->actingAs($this->admin)->get('/admin/streams')->assertSuccessful()->assertSee('Streams');
    $this->actingAs($this->admin)->get('/admin/streams/create')->assertSuccessful();

    $this->actingAs($this->admin)->get('/admin/courses')->assertSuccessful()->assertSee('Courses');
    $this->actingAs($this->admin)->get('/admin/courses/create')->assertSuccessful();

    $this->actingAs($this->admin)->get('/admin/specializations')->assertSuccessful()->assertSee('Specializations');
    $this->actingAs($this->admin)->get('/admin/specializations/create')->assertSuccessful();
});

test('state resource can be listed and created via livewire', function () {
    $this->actingAs($this->admin);

    Livewire::test(ListStates::class)->assertSuccessful();

    Livewire::test(CreateState::class)
        ->fillForm([
            'name' => 'Karnataka',
            'slug' => 'karnataka',
            'status' => true,
        ])
        ->call('create')
        ->assertHasNoFormErrors();

    $this->assertDatabaseHas('states', [
        'name' => 'Karnataka',
        'slug' => 'karnataka',
        'status' => true,
    ]);
});

test('city resource can be listed and created via livewire', function () {
    $this->actingAs($this->admin);

    $state = State::create([
        'name' => 'Karnataka City Test',
        'slug' => 'karnataka-city-test',
        'status' => true,
    ]);

    Livewire::test(ListCities::class)->assertSuccessful();

    Livewire::test(CreateCity::class)
        ->fillForm([
            'state_id' => $state->id,
            'name' => 'Bengaluru',
            'slug' => 'bengaluru',
            'is_popular' => false,
            'status' => true,
        ])
        ->call('create')
        ->assertHasNoFormErrors();

    $this->assertDatabaseHas('cities', [
        'state_id' => $state->id,
        'name' => 'Bengaluru',
        'slug' => 'bengaluru',
    ]);
});

test('stream resource can be listed and created via livewire', function () {
    $this->actingAs($this->admin);

    Livewire::test(ListStreams::class)->assertSuccessful();

    Livewire::test(CreateStream::class)
        ->fillForm([
            'name' => 'Information Technology',
            'slug' => 'information-technology',
            'icon' => 'fa-laptop-code',
        ])
        ->call('create')
        ->assertHasNoFormErrors();

    $this->assertDatabaseHas('streams', [
        'name' => 'Information Technology',
        'slug' => 'information-technology',
        'icon' => 'fa-laptop-code',
    ]);
});

test('course resource can be listed and created via livewire', function () {
    $this->actingAs($this->admin);

    $stream = Stream::create([
        'name' => 'Management Stream Test',
        'slug' => 'management-stream-test',
    ]);

    Livewire::test(ListCourses::class)->assertSuccessful();

    Livewire::test(CreateCourse::class)
        ->fillForm([
            'stream_id' => $stream->id,
            'name' => 'Master of Business Administration',
            'slug' => 'mba-course-test',
            'level' => 'PG',
            'degree_type' => 'Degree',
            'duration' => '2 Years',
        ])
        ->call('create')
        ->assertHasNoFormErrors();

    $this->assertDatabaseHas('courses', [
        'stream_id' => $stream->id,
        'name' => 'Master of Business Administration',
        'slug' => 'mba-course-test',
        'level' => 'PG',
    ]);
});

test('specialization resource can be listed and created via livewire', function () {
    $this->actingAs($this->admin);

    $stream = Stream::create([
        'name' => 'Engineering Spec Test',
        'slug' => 'engineering-spec-test',
    ]);

    $course = Course::create([
        'stream_id' => $stream->id,
        'name' => 'B.Tech Specialization Test',
        'slug' => 'btech-spec-test',
        'level' => 'UG',
        'degree_type' => 'Degree',
        'duration' => '4 Years',
    ]);

    Livewire::test(ListSpecializations::class)->assertSuccessful();

    Livewire::test(CreateSpecialization::class)
        ->fillForm([
            'course_id' => $course->id,
            'name' => 'Cyber Security',
            'slug' => 'cyber-security',
            'status' => true,
        ])
        ->call('create')
        ->assertHasNoFormErrors();

    $this->assertDatabaseHas('specializations', [
        'course_id' => $course->id,
        'name' => 'Cyber Security',
        'slug' => 'cyber-security',
        'status' => true,
    ]);
});

test('state deletion guard prevents deletion when state has child cities', function () {
    $this->actingAs($this->admin);

    $state = State::create([
        'name' => 'Gujarat Guard Test',
        'slug' => 'gujarat-guard-test',
        'status' => true,
    ]);

    City::create([
        'state_id' => $state->id,
        'name' => 'Ahmedabad',
        'slug' => 'ahmedabad',
        'is_popular' => false,
        'status' => true,
    ]);

    Livewire::test(ListStates::class)
        ->callTableAction('delete', $state);

    $this->assertDatabaseHas('states', [
        'id' => $state->id,
    ]);
});

test('stream deletion guard prevents deletion when stream has child courses', function () {
    $this->actingAs($this->admin);

    $stream = Stream::create([
        'name' => 'Medical Guard Test',
        'slug' => 'medical-guard-test',
    ]);

    Course::create([
        'stream_id' => $stream->id,
        'name' => 'MBBS Guard Test',
        'slug' => 'mbbs-guard-test',
        'level' => 'UG',
        'degree_type' => 'Degree',
        'duration' => '5 Years',
    ]);

    Livewire::test(ListStreams::class)
        ->callTableAction('delete', $stream);

    $this->assertDatabaseHas('streams', [
        'id' => $stream->id,
    ]);
});

test('city popular validation rejects when more than 10 popular cities exist', function () {
    $this->actingAs($this->admin);

    $state = State::create([
        'name' => 'Popular State Test',
        'slug' => 'popular-state-test',
        'status' => true,
    ]);

    // Seed 10 popular cities
    for ($i = 1; $i <= 10; $i++) {
        City::create([
            'state_id' => $state->id,
            'name' => "Popular City {$i}",
            'slug' => "popular-city-{$i}",
            'is_popular' => true,
            'status' => true,
        ]);
    }

    Livewire::test(CreateCity::class)
        ->fillForm([
            'state_id' => $state->id,
            'name' => 'Eleventh City',
            'slug' => 'eleventh-city',
            'is_popular' => true,
            'status' => true,
        ])
        ->call('create')
        ->assertHasFormErrors(['is_popular']);
});
