<?php

use App\Models\College;

function createDockTestCollege(array $attributes = []): College
{
    static $counter = 1;
    $idx = $counter++;

    return College::create(array_merge([
        'name' => 'Dock University '.$idx,
        'short_name' => 'Dock Univ '.$idx,
        'slug' => 'dock-univ-'.$idx,
        'mode' => 'regular',
        'type' => 'Private',
        'state' => 'Haryana',
        'city' => 'Gurugram',
        'status' => true,
        'rating' => 4.4,
        'established_year' => 2012,
        'banner' => 'colleges/banners/sample.jpg',
    ], $attributes));
}

test('layout includes comparison dock markup and javascript engine', function () {
    $response = $this->get(route('home'));

    $response->assertStatus(200);
    $response->assertSee('id="gpCompareDock"', false);
    $response->assertSee('gp-compare-dock-title', false);
    $response->assertSee('Compare Colleges');
    $response->assertSee('GP_COMPARE', false);
    $response->assertSee('growpec_compare_colleges', false);
    $response->assertSee('gpCompareSubmitBtn', false);
});

test('college listing cards include compare quick action buttons with data attributes', function () {
    $college = createDockTestCollege([
        'name' => 'Horizon Science Campus',
        'slug' => 'horizon-science-campus',
    ]);

    $response = $this->get(route('colleges.regular'));

    $response->assertStatus(200);
    $response->assertSee('btn-add-compare', false);
    $response->assertSee('data-college-slug="horizon-science-campus"', false);
    $response->assertSee('toggleCollegeComparison(this)', false);
    $response->assertSee('Compare');
});

test('college detail profile includes add to compare action button', function () {
    $college = createDockTestCollege([
        'name' => 'Vanguard Institute of Technology',
        'slug' => 'vanguard-institute-of-technology',
    ]);

    $response = $this->get(route('college.show', $college->slug));

    $response->assertStatus(200);
    $response->assertSee('btn-add-compare', false);
    $response->assertSee('data-college-slug="vanguard-institute-of-technology"', false);
    $response->assertSee('data-full-label="true"', false);
    $response->assertSee('Add to Compare');
});

test('compare matrix view includes sync script and remove triggers', function () {
    $col1 = createDockTestCollege(['name' => 'Pinnacle College A', 'slug' => 'pinnacle-college-a']);
    $col2 = createDockTestCollege(['name' => 'Pinnacle College B', 'slug' => 'pinnacle-college-b']);

    $response = $this->get(route('colleges.compare', [
        'colleges' => 'pinnacle-college-a,pinnacle-college-b',
    ]));

    $response->assertStatus(200);
    $response->assertSee('id="compareSelectorBar"', false);
    $response->assertSee('GP_COMPARE.remove', false);
    $response->assertSee('activeColleges', false);
    $response->assertSee('Pinnacle College A');
    $response->assertSee('Pinnacle College B');
});
