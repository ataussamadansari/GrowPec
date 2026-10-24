<?php

use App\Models\College;
use Database\Seeders\MeerutCollegesSeeder;
use Database\Seeders\StreamCourseSpecializationSeeder;
use Illuminate\Support\Facades\DB;

beforeEach(function () {
    if (DB::table('courses')->count() === 0) {
        $this->seed(StreamCourseSpecializationSeeder::class);
    }
    $this->seed(MeerutCollegesSeeder::class);
});

test('meerut colleges seeder inserts all 6 colleges with authentic courses and returns 200 OK on profile page', function (string $slug, string $name, string $expectedCourse) {
    $college = College::where('slug', $slug)->first();

    expect($college)->not->toBeNull();
    expect($college->name)->toBe($name);
    expect($college->city->name)->toBe('Meerut');
    expect($college->state->name)->toBe('Uttar Pradesh');
    expect($college->collegeCourses()->count())->toBeGreaterThan(0);

    // Verify public profile page loads with 200 OK
    $response = $this->get(route('college.show', $college->slug));
    $response->assertStatus(200);
    $response->assertSee($name);
    $response->assertSee($expectedCourse);
})->with([
    ['forte-institute-of-technology-meerut', 'Forte Institute of Technology', 'Computer Applications & Web Development'],
    ['abss-institute-of-technology-meerut', 'ABSS Institute of Technology', 'Computer Science & Engineering'],
    ['dewan-vs-group-of-institutions-meerut', 'Dewan V.S. Group of Institutions', 'Computer Science & Engineering'],
    ['meerut-institute-of-engineering-and-technology-miet', 'Meerut Institute of Engineering and Technology', 'Computer Science & Engineering'],
    ['bharat-institute-of-technology-bit-meerut', 'Bharat Institute of Technology', 'Computer Science & Engineering'],
    ['translam-institute-of-technology-and-management-meerut', 'Translam Institute of Technology and Management', 'Computer Science & Engineering'],
]);
