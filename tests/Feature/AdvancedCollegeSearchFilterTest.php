<?php

use App\Models\College;
use App\Models\CollegeCourse;
use App\Models\Course;
use App\Models\Stream;

$createdCollegeIds = [];

function createFilterTestCollege(array $attributes = []): College
{
    global $createdCollegeIds;
    static $counter = 1;
    $idx = $counter++;

    $college = College::create(array_merge([
        'name' => 'Filter University '.$idx,
        'short_name' => 'Filter Univ '.$idx,
        'slug' => 'filter-univ-'.$idx.'-'.uniqid(),
        'college_mode' => 'regular',
        'type' => 'Private',
        'college_type' => 'Private',
        'state' => 'Karnataka',
        'city' => 'Bangalore',
        'status' => true,
        'rating' => 4.2,
        'established_year' => 2010 + $idx,
    ], $attributes));

    $createdCollegeIds[] = $college->id;

    return $college;
}

function attachTestCourse(College $college, string $streamSlug, string $streamName, string $courseSlug, string $courseName, int $fee = 150000): void
{
    $stream = Stream::firstOrCreate(
        ['slug' => $streamSlug],
        ['name' => $streamName]
    );

    $course = Course::firstOrCreate(
        ['slug' => $courseSlug],
        [
            'name' => $courseName,
            'stream_id' => $stream->id,
            'level' => 'UG',
            'degree_type' => 'Degree',
            'duration' => '4 Years',
        ]
    );

    CollegeCourse::create([
        'college_id' => $college->id,
        'course_id' => $course->id,
        'fee_amount' => $fee,
        'status' => true,
    ]);
}

afterEach(function () {
    global $createdCollegeIds;
    if (! empty($createdCollegeIds)) {
        CollegeCourse::whereIn('college_id', $createdCollegeIds)->delete();
        College::whereIn('id', $createdCollegeIds)->delete();
        $createdCollegeIds = [];
    }
});

test('can filter regular colleges by stream slug or array', function () {
    $col1 = createFilterTestCollege(['name' => 'Institute of Engineering Excellence']);
    $col2 = createFilterTestCollege(['name' => 'School of Management Studies']);

    attachTestCourse($col1, 'engineering-tech', 'Engineering Tech', 'b-tech-cs', 'B.Tech CS');
    attachTestCourse($col2, 'management-business', 'Management Business', 'mba-finance', 'MBA Finance');

    $response = $this->get(route('colleges.regular', ['stream' => 'engineering-tech']));

    $response->assertStatus(200);
    expect($response->viewData('colleges')->pluck('id'))->toContain($col1->id);
    expect($response->viewData('colleges')->pluck('id'))->not->toContain($col2->id);

    $response->assertSee(route('college.show', $col1->slug));
    $response->assertDontSee(route('college.show', $col2->slug));
    $response->assertSee('Stream: Engineering Tech');
});

test('can filter colleges by specific course slug', function () {
    $col1 = createFilterTestCollege(['name' => 'Pioneer Tech Campus']);
    $col2 = createFilterTestCollege(['name' => 'Heritage Medical College']);

    attachTestCourse($col1, 'engineering', 'Engineering', 'b-tech-it', 'B.Tech IT');
    attachTestCourse($col2, 'medical', 'Medical', 'mbbs', 'MBBS');

    $response = $this->get(route('colleges.regular', ['course' => 'b-tech-it']));

    $response->assertStatus(200);
    expect($response->viewData('colleges')->pluck('id'))->toContain($col1->id);
    expect($response->viewData('colleges')->pluck('id'))->not->toContain($col2->id);

    $response->assertSee(route('college.show', $col1->slug));
    $response->assertDontSee(route('college.show', $col2->slug));
    $response->assertSee('Course: B TECH IT');
});

test('can filter colleges by location state and city', function () {
    $col1 = createFilterTestCollege([
        'name' => 'Bangalore Science Academy',
        'state' => 'Karnataka',
        'city' => 'Bangalore',
    ]);
    $col2 = createFilterTestCollege([
        'name' => 'Pune Institute of Commerce',
        'state' => 'Maharashtra',
        'city' => 'Pune',
    ]);

    // Filter by state
    $responseState = $this->get(route('colleges.regular', ['state' => 'Karnataka']));
    $responseState->assertStatus(200);
    expect($responseState->viewData('colleges')->pluck('id'))->toContain($col1->id);
    expect($responseState->viewData('colleges')->pluck('id'))->not->toContain($col2->id);
    $responseState->assertSee(route('college.show', $col1->slug));
    $responseState->assertDontSee(route('college.show', $col2->slug));
    $responseState->assertSee('State: Karnataka');

    // Filter by city
    $responseCity = $this->get(route('colleges.regular', ['city' => 'Pune']));
    $responseCity->assertStatus(200);
    expect($responseCity->viewData('colleges')->pluck('id'))->toContain($col2->id);
    expect($responseCity->viewData('colleges')->pluck('id'))->not->toContain($col1->id);
    $responseCity->assertSee(route('college.show', $col2->slug));
    $responseCity->assertDontSee(route('college.show', $col1->slug));
    $responseCity->assertSee('City: Pune');
});

test('can filter colleges by fee range brackets', function () {
    $col1 = createFilterTestCollege(['name' => 'Affordable Polytechnic']);
    $col2 = createFilterTestCollege(['name' => 'Elite Business School']);

    attachTestCourse($col1, 'polytechnic', 'Polytechnic', 'diploma-mech', 'Diploma Mech', 65000); // < 1 Lakh
    attachTestCourse($col2, 'business', 'Business', 'pgdm-global', 'PGDM Global', 850000); // 5 - 10 Lakh

    $response = $this->get(route('colleges.regular', ['fee_range' => 'under_1l']));

    $response->assertStatus(200);
    expect($response->viewData('colleges')->pluck('id'))->toContain($col1->id);
    expect($response->viewData('colleges')->pluck('id'))->not->toContain($col2->id);
    $response->assertSee(route('college.show', $col1->slug));
    $response->assertDontSee(route('college.show', $col2->slug));
    $response->assertSee('Fee: < ₹1 Lac');
});

test('can sort colleges by rating and alphabetical name', function () {
    $colA = createFilterTestCollege([
        'name' => 'Alpha University',
        'rating' => 3.8,
        'is_featured' => false,
    ]);
    $colB = createFilterTestCollege([
        'name' => 'Beta University',
        'rating' => 4.9,
        'is_featured' => false,
    ]);

    // Sort by rating descending: Beta should precede Alpha
    $responseRating = $this->get(route('colleges.regular', ['sort' => 'rating_desc']));
    $responseRating->assertStatus(200);
    $contentRating = $responseRating->getContent();
    $posBeta = strpos($contentRating, route('college.show', $colB->slug));
    $posAlpha = strpos($contentRating, route('college.show', $colA->slug));
    expect($posBeta)->toBeLessThan($posAlpha);

    // Sort by name ascending: Alpha should precede Beta
    $responseName = $this->get(route('colleges.regular', ['sort' => 'name_asc']));
    $responseName->assertStatus(200);
    $contentName = $responseName->getContent();
    $posAlphaAsc = strpos($contentName, route('college.show', $colA->slug));
    $posBetaAsc = strpos($contentName, route('college.show', $colB->slug));
    expect($posAlphaAsc)->toBeLessThan($posBetaAsc);
});

test('active filter chips render individual remove URLs and preserve sort', function () {
    $col = createFilterTestCollege([
        'name' => 'Mysore Royal College',
        'state' => 'Karnataka',
    ]);

    $response = $this->get(route('colleges.regular', [
        'state' => 'Karnataka',
        'sort' => 'rating_desc',
    ]));

    $response->assertStatus(200);
    $response->assertSee('Active Filters (1):');
    $response->assertSee('State: Karnataka');
    // The removal link should drop 'state' while retaining 'sort=rating_desc'
    $response->assertSee('sort=rating_desc');
    $response->assertSee('Clear All');
});

test('pagination links preserve active filter queries', function () {
    $response = $this->get(route('colleges.regular', [
        'state' => 'Karnataka',
        'sort' => 'rating_desc',
    ]));

    $response->assertStatus(200);
    $paginator = $response->viewData('colleges');
    $page2Url = $paginator->url(2);

    expect($page2Url)->toContain('state=Karnataka');
    expect($page2Url)->toContain('sort=rating_desc');
});

test('can filter online colleges by stream and course level', function () {
    $onlineCol1 = createFilterTestCollege([
        'name' => 'Global Online Tech University',
        'college_mode' => 'online',
    ]);
    $onlineCol2 = createFilterTestCollege([
        'name' => 'National Distance Humanities University',
        'college_mode' => 'online',
    ]);

    $stream = Stream::firstOrCreate(
        ['slug' => 'computer-science-online'],
        ['name' => 'Computer Science']
    );
    $course = Course::firstOrCreate(
        ['slug' => 'mca-online'],
        [
            'name' => 'MCA Online',
            'stream_id' => $stream->id,
            'level' => 'PG',
            'degree_type' => 'Degree',
            'duration' => '2 Years',
        ]
    );

    CollegeCourse::create([
        'college_id' => $onlineCol1->id,
        'course_id' => $course->id,
        'fee_amount' => 120000,
        'status' => true,
    ]);

    $response = $this->get(route('colleges.online', [
        'stream' => 'computer-science-online',
        'level' => 'PG',
    ]));

    $response->assertStatus(200);
    expect($response->viewData('colleges')->pluck('id'))->toContain($onlineCol1->id);
    expect($response->viewData('colleges')->pluck('id'))->not->toContain($onlineCol2->id);

    $response->assertSee(route('college.show', $onlineCol1->slug));
    $response->assertDontSee(route('college.show', $onlineCol2->slug));
    $response->assertSee('Stream: Computer Science');
    $response->assertSee('Level: PG');
});

test('can filter colleges by compound multi-dimensional criteria simultaneously', function () {
    $targetCol = createFilterTestCollege([
        'name' => 'Target Compound College',
        'state' => 'Karnataka',
        'city' => 'Bangalore',
    ]);
    $wrongStateCol = createFilterTestCollege([
        'name' => 'Wrong State College',
        'state' => 'Maharashtra',
        'city' => 'Mumbai',
    ]);
    $wrongFeeCol = createFilterTestCollege([
        'name' => 'Wrong Fee College',
        'state' => 'Karnataka',
        'city' => 'Bangalore',
    ]);

    attachTestCourse($targetCol, 'biotechnology', 'Biotechnology', 'b-tech-biotech', 'B.Tech Biotech', 80000); // under 1L
    attachTestCourse($wrongStateCol, 'biotechnology', 'Biotechnology', 'b-tech-biotech', 'B.Tech Biotech', 80000); // under 1L, but wrong state
    attachTestCourse($wrongFeeCol, 'biotechnology', 'Biotechnology', 'b-tech-biotech', 'B.Tech Biotech', 450000); // right stream & state, but fee 3-5L

    $response = $this->get(route('colleges.regular', [
        'stream' => 'biotechnology',
        'state' => 'Karnataka',
        'fee_range' => 'under_1l',
    ]));

    $response->assertStatus(200);
    $matchedIds = $response->viewData('colleges')->pluck('id');
    expect($matchedIds)->toContain($targetCol->id);
    expect($matchedIds)->not->toContain($wrongStateCol->id);
    expect($matchedIds)->not->toContain($wrongFeeCol->id);

    $response->assertSee(route('college.show', $targetCol->slug));
    $response->assertDontSee(route('college.show', $wrongStateCol->slug));
    $response->assertDontSee(route('college.show', $wrongFeeCol->slug));
    $response->assertSee('Active Filters (3):');
});
