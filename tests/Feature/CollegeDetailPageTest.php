<?php

use App\Models\College;
use App\Models\CollegeCourse;
use App\Models\CollegeHighlight;
use App\Models\Course;
use App\Models\Specialization;
use App\Models\Stream;
use Illuminate\Support\Facades\Schema;

function makeDetailPageCollege(array $attributes = []): College
{
    return College::create(array_merge([
        'name' => 'Apex Global University',
        'slug' => 'apex-global-university-'.uniqid(),
        'college_mode' => 'regular',
        'state' => 'Maharashtra',
        'city' => 'Pune',
        'status' => true,
        'rating' => 4.6,
        'tagline' => 'Excellence in Engineering & Technology',
        'about' => 'Leading institution offering top-tier accredited degree programs.',
    ], $attributes));
}

test('public college detail page loads successfully with 200 OK for an active college', function () {
    $college = makeDetailPageCollege();

    $response = $this->get(route('college.show', $college->slug));

    $response->assertStatus(200);
    $response->assertSee('Apex Global University');
    $response->assertSee('Pune');
});

test('public college detail page returns 404 for inactive or non-existent college', function () {
    $inactive = makeDetailPageCollege(['status' => false]);

    $this->get(route('college.show', $inactive->slug))
        ->assertStatus(404);

    $this->get(route('college.show', 'non-existent-college-slug-xyz'))
        ->assertStatus(404);
});

test('public college detail page displays college highlights', function () {
    $college = makeDetailPageCollege();

    CollegeHighlight::create([
        'college_id' => $college->id,
        'title' => 'Top 10 Engineering Institute in India',
        'sort_order' => 1,
        'status' => true,
    ]);

    $response = $this->get(route('college.show', $college->slug));

    $response->assertStatus(200);
    $response->assertSee('Top 10 Engineering Institute in India');
});

test('public college detail page renders course program rows directly from college courses', function () {
    $college = makeDetailPageCollege();

    $stream = Stream::create([
        'name' => 'Engineering & Technology',
        'slug' => 'eng-tech-'.uniqid(),
        'status' => true,
    ]);

    $course = Course::create([
        'stream_id' => $stream->id,
        'name' => 'Bachelor of Technology',
        'slug' => 'b-tech-'.uniqid(),
        'duration' => '4 Years',
        'status' => true,
    ]);

    $specialization = Specialization::create([
        'course_id' => $course->id,
        'name' => 'Artificial Intelligence & Machine Learning',
        'slug' => 'btech-aiml-'.uniqid(),
        'status' => true,
    ]);

    CollegeCourse::create([
        'college_id' => $college->id,
        'course_id' => $course->id,
        'specialization_id' => $specialization->id,
        'specialization' => 'Artificial Intelligence & Machine Learning',
        'fee_amount' => 175000.00,
        'fee_type' => 'per_year',
        'duration' => '4 Years',
        'eligibility' => '10+2 with PCM (min 60%)',
        'seats' => 60,
        'status' => true,
    ]);

    $response = $this->get(route('college.show', $college->slug));

    $response->assertStatus(200);
    $response->assertSee('Bachelor of Technology');
    $response->assertSee('Artificial Intelligence & Machine Learning');
    $response->assertSee('10+2 with PCM (min 60%)');
});

test('public college detail page renders gracefully when college has no courses', function () {
    $college = makeDetailPageCollege();

    $response = $this->get(route('college.show', $college->slug));

    $response->assertStatus(200);
    $response->assertSee($college->name);
});

test('normalized database schema confirms redundant tables do not exist', function () {
    expect(Schema::hasTable('college_course_fees'))->toBeFalse()
        ->and(Schema::hasTable('college_course_specializations'))->toBeFalse()
        ->and(Schema::hasTable('college_learning_experiences'))->toBeFalse()
        ->and(Schema::hasTable('college_comparisons'))->toBeFalse();
});
