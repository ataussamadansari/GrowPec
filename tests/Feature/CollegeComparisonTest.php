<?php

use App\Models\College;
use App\Models\CollegeCourse;
use App\Models\CollegeFacility;
use App\Models\Course;
use App\Models\Stream;

function makeCompareCollege(array $attributes = []): College
{
    static $index = 1;
    $idx = $index++;

    return College::create(array_merge([
        'name' => 'Benchmark University '.$idx,
        'short_name' => 'Benchmark '.$idx,
        'slug' => 'benchmark-univ-'.$idx,
        'mode' => 'regular',
        'type' => 'Private',
        'state' => 'Uttar Pradesh',
        'city' => 'Noida',
        'status' => true,
        'rating' => 4.5,
        'established_year' => 2010 + $idx,
        'naac_grade' => 'A+',
        'ugc_approved' => true,
        'nirf_rank' => '45',
        'highest_package' => '₹24.00 LPA',
        'average_package' => '₹6.50 LPA',
    ], $attributes));
}

test('compare page loads successfully in launcher mode when no colleges specified', function () {
    $response = $this->get(route('colleges.compare'));

    $response->assertStatus(200);
    $response->assertSee('Compare Top Universities & Colleges', false);
    $response->assertSee('Popular University Benchmark Pairs');
    $response->assertSee('Bennett University vs Galgotias University');
});

test('compare page renders side-by-side comparison matrix for 2 colleges', function () {
    $col1 = makeCompareCollege(['name' => 'Apex Tech Institute', 'slug' => 'apex-tech-institute']);
    $col2 = makeCompareCollege(['name' => 'Zenith Business Academy', 'slug' => 'zenith-business-academy']);

    $response = $this->get(route('colleges.compare', [
        'colleges' => 'apex-tech-institute,zenith-business-academy',
    ]));

    $response->assertStatus(200);
    $response->assertSee('Comparison Matrix');
    $response->assertSee('Apex Tech Institute');
    $response->assertSee('Zenith Business Academy');
    $response->assertSee('Accreditations & Recognitions', false);
    $response->assertSee('Annual Fee Range');
    $response->assertSee('Placements & Career Statistics', false);
    $response->assertSee('Campus Amenities & Infrastructure', false);
});

test('compare page supports up to 4 colleges simultaneously', function () {
    $c1 = makeCompareCollege(['name' => 'Alpha University', 'slug' => 'alpha-univ']);
    $c2 = makeCompareCollege(['name' => 'Beta University', 'slug' => 'beta-univ']);
    $c3 = makeCompareCollege(['name' => 'Gamma University', 'slug' => 'gamma-univ']);
    $c4 = makeCompareCollege(['name' => 'Delta University', 'slug' => 'delta-univ']);

    $response = $this->get(route('colleges.compare', [
        'colleges' => 'alpha-univ,beta-univ,gamma-univ,delta-univ',
    ]));

    $response->assertStatus(200);
    $response->assertSee('Alpha University');
    $response->assertSee('Beta University');
    $response->assertSee('Gamma University');
    $response->assertSee('Delta University');
    $response->assertSee('Comparing 4 of 4 Colleges');
});

test('invalid or inactive college slugs are safely omitted without error', function () {
    $active = makeCompareCollege(['name' => 'Valid Active College', 'slug' => 'valid-active-col']);
    $inactive = makeCompareCollege(['name' => 'Inactive College', 'slug' => 'inactive-col', 'status' => false]);

    $response = $this->get(route('colleges.compare', [
        'colleges' => 'valid-active-col,inactive-col,non-existent-college-slug',
    ]));

    $response->assertStatus(200);
    // When only 1 valid college is found, renders launcher state instead of breaking
    $response->assertSee('Popular University Benchmark Pairs');
});

test('enquire now action buttons contain college IDs for lead modal integration', function () {
    $col1 = makeCompareCollege(['name' => 'Prime Engineering College', 'slug' => 'prime-eng-col']);
    $col2 = makeCompareCollege(['name' => 'Vanguard Law University', 'slug' => 'vanguard-law-univ']);

    $response = $this->get(route('colleges.compare', [
        'colleges' => 'prime-eng-col,vanguard-law-univ',
    ]));

    $response->assertStatus(200);
    $response->assertSee('data-college-id="'.$col1->id.'"', false);
    $response->assertSee('data-college-id="'.$col2->id.'"', false);
    $response->assertSee('data-college-name="'.$col1->name.'"', false);
    $response->assertSee('data-college-name="'.$col2->name.'"', false);
});

test('compare page displays accreditations, facilities, and fee highlights', function () {
    $stream = Stream::firstOrCreate(['name' => 'Engineering', 'slug' => 'engineering-comp-test']);
    $course = Course::firstOrCreate([
        'stream_id' => $stream->id,
        'name' => 'B.Tech Computer Science',
        'slug' => 'btech-cse-comp-test',
    ]);

    $col1 = makeCompareCollege(['name' => 'Heritage University', 'slug' => 'heritage-univ']);
    $col2 = makeCompareCollege(['name' => 'Pioneer Institute', 'slug' => 'pioneer-inst']);

    CollegeCourse::create([
        'college_id' => $col1->id,
        'course_id' => $course->id,
        'fee_amount' => 150000,
        'fee_type' => 'annually',
        'duration' => '4 Years',
        'status' => true,
    ]);

    CollegeFacility::create([
        'college_id' => $col1->id,
        'name' => 'Olympic Sports Complex',
        'status' => true,
    ]);

    $response = $this->get(route('colleges.compare', [
        'colleges' => 'heritage-univ,pioneer-inst',
    ]));

    $response->assertStatus(200);
    $response->assertSee('₹150,000');
    $response->assertSee('Olympic Sports Complex');
    $response->assertSee('B.Tech Computer Science');
});
