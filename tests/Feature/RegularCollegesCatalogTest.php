<?php

use App\Models\College;
use Database\Seeders\RegularCollegeSeeder;
use Database\Seeders\StreamCourseSpecializationSeeder;
use Illuminate\Support\Facades\DB;

beforeEach(function () {
    // Seed prerequisites if not present
    if (DB::table('courses')->count() === 0) {
        $this->seed(StreamCourseSpecializationSeeder::class);
    }
});

test('regular college seeder populates all 15 expected colleges', function () {
    $this->seed(RegularCollegeSeeder::class);

    $expectedSlugs = [
        'graphic-era-deemed-to-be-university-dehradun',
        'iimt-university-meerut',
        'bennett-university-greater-noida',
        'metro-university-greater-noida',
        'dr-k-n-modi-university-modinagar',
        'galgotias-university-greater-noida',
        'teerthanker-mahaveer-university-moradabad',
        'amrapali-university-haldwani',
        'maharishi-university-of-information-technology-noida',
        'future-university-bareilly',
        'haridwar-university-roorkee',
        'coer-university-roorkee',
        'hrit-group-of-institutions-ghaziabad',
        'srm-institute-of-science-and-technology-ncr-campus-ghaziabad',
        'noida-international-university-greater-noida',
    ];

    $regularColleges = DB::table('colleges')
        ->where('college_mode', 'regular')
        ->pluck('slug')
        ->toArray();

    foreach ($expectedSlugs as $slug) {
        expect($regularColleges)->toContain($slug);
    }

    expect(count($regularColleges))->toBeGreaterThanOrEqual(15);
});

test('each seeded regular college contains courses, highlights, and facilities', function () {
    $this->seed(RegularCollegeSeeder::class);

    $colleges = College::where('college_mode', 'regular')->get();

    expect($colleges->count())->toBeGreaterThanOrEqual(15);

    foreach ($colleges as $college) {
        expect($college->collegeCourses()->count())->toBeGreaterThan(0);
        expect($college->collegeHighlights()->count())->toBeGreaterThan(0);
        expect($college->collegeFacilities()->count())->toBeGreaterThan(0);
    }
});

test('public show route loads with 200 OK for newly seeded regular colleges', function (string $slug) {
    $this->seed(RegularCollegeSeeder::class);

    $response = $this->get(route('college.show', $slug));
    $response->assertStatus(200);
})->with([
    'maharishi-university-of-information-technology-noida',
    'future-university-bareilly',
    'haridwar-university-roorkee',
    'coer-university-roorkee',
    'hrit-group-of-institutions-ghaziabad',
    'srm-institute-of-science-and-technology-ncr-campus-ghaziabad',
    'noida-international-university-greater-noida',
]);
