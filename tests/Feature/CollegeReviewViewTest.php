<?php

use App\Models\College;
use App\Models\CollegeReview;

function makeCollegeForViewTest(): College
{
    return College::create([
        'name' => 'Prestige Global Institute',
        'slug' => 'prestige-global-institute-'.uniqid(),
        'college_mode' => 'online',
        'state' => 'Maharashtra',
        'city' => 'Pune',
        'status' => true,
        'rating' => 4.2,
    ]);
}

test('public college page renders student reviews section and quick nav item', function () {
    $college = makeCollegeForViewTest();

    $response = $this->get(route('college.show', $college->slug));

    $response->assertStatus(200);
    $response->assertSee('id="sec-reviews"', false);
    $response->assertSee('Student Reviews');
    $response->assertSee('Write a Review');
});

test('public college page displays approved reviews and strictly excludes pending and rejected reviews', function () {
    $college = makeCollegeForViewTest();

    // 1. Approved Review
    CollegeReview::create([
        'college_id' => $college->id,
        'reviewer_name' => 'Meera Krishnan',
        'email' => 'meera@example.com',
        'course' => 'M.Sc Data Science',
        'rating' => 5,
        'review' => 'World class online curriculum and extraordinary project mentorship.',
        'status' => 'approved',
    ]);

    // 2. Pending Review
    CollegeReview::create([
        'college_id' => $college->id,
        'reviewer_name' => 'Pending Visitor',
        'email' => 'pending@example.com',
        'course' => 'BBA',
        'rating' => 2,
        'review' => 'This is a pending feedback waiting for moderation.',
        'status' => 'pending',
    ]);

    // 3. Rejected Review
    CollegeReview::create([
        'college_id' => $college->id,
        'reviewer_name' => 'Spam Bot User',
        'email' => 'bot@example.com',
        'rating' => 1,
        'review' => 'Unapproved spam promotional advertisement message here.',
        'status' => 'rejected',
    ]);

    $response = $this->get(route('college.show', $college->slug));

    $response->assertStatus(200);

    // Must see approved review details
    $response->assertSee('Meera Krishnan');
    $response->assertSee('M.Sc Data Science');
    $response->assertSee('World class online curriculum and extraordinary project mentorship.');
    $response->assertSee('Verified Review');

    // Must NOT see pending or rejected review content
    $response->assertDontSee('Pending Visitor');
    $response->assertDontSee('This is a pending feedback waiting for moderation.');
    $response->assertDontSee('Spam Bot User');
    $response->assertDontSee('Unapproved spam promotional advertisement message here.');
});

test('empty state renders when a college has no approved reviews', function () {
    $college = makeCollegeForViewTest();

    $response = $this->get(route('college.show', $college->slug));

    $response->assertStatus(200);
    $response->assertSee('Be the First to Review');
    $response->assertSee('No visitor reviews yet for');
});

test('write a review form contains required inputs, csrf and honeypot field', function () {
    $college = makeCollegeForViewTest();

    $response = $this->get(route('college.show', $college->slug));

    $response->assertStatus(200);
    $response->assertSee('action="'.route('college.reviews.store', $college->slug).'"', false);
    $response->assertSee('name="website_hp"', false);
    $response->assertSee('name="reviewer_name"', false);
    $response->assertSee('name="email"', false);
    $response->assertSee('name="course"', false);
    $response->assertSee('name="rating"', false);
    $response->assertSee('name="review"', false);
    $response->assertSee('Submit Review');
});

test('success flash alert displays when review_success session key is present', function () {
    $college = makeCollegeForViewTest();

    $response = $this->withSession([
        'review_success' => 'Thank you! Your review has been submitted and is awaiting administrator moderation.',
    ])->get(route('college.show', $college->slug));

    $response->assertStatus(200);
    $response->assertSee('Thank you! Your review has been submitted and is awaiting administrator moderation.');
});
