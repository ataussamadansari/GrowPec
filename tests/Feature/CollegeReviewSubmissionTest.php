<?php

use App\Models\College;
use App\Models\CollegeReview;

function makeCollegeForSubmission(): College
{
    return College::create([
        'name' => 'Zenith Global University',
        'slug' => 'zenith-global-university-'.uniqid(),
        'college_mode' => 'online',
        'state' => 'Uttar Pradesh',
        'city' => 'Noida',
        'status' => true,
    ]);
}

test('guest can submit valid review and receives success flash message', function () {
    $college = makeCollegeForSubmission();

    $response = $this->post(route('college.reviews.store', $college->slug), [
        'reviewer_name' => 'Aman Gupta',
        'email' => 'Aman@Example.com',
        'course' => 'Online MBA',
        'rating' => 5,
        'review' => 'Exceptional faculties, great LMS support, and comprehensive course materials.',
    ]);

    $response->assertSessionHas('review_success');
    $response->assertRedirect();

    $this->assertDatabaseHas('college_reviews', [
        'college_id' => $college->id,
        'reviewer_name' => 'Aman Gupta',
        'email' => 'aman@example.com',
        'course' => 'Online MBA',
        'rating' => 5,
        'status' => 'pending',
        'is_verified' => false,
    ]);

    $review = CollegeReview::where('college_id', $college->id)->first();
    expect($review->isPending())->toBeTrue()
        ->and($review->ip_address)->not->toBeNull();
});

test('guest can submit valid review via JSON API and receives 201 response', function () {
    $college = makeCollegeForSubmission();

    $response = $this->postJson(route('college.reviews.store', $college->slug), [
        'reviewer_name' => 'Sneha Roy',
        'email' => 'sneha@example.com',
        'course_enrolled' => 'Online MCA',
        'rating' => 4,
        'review_text' => 'Seamless digital experience and very prompt doubt solving sessions.',
    ]);

    $response->assertStatus(201)
        ->assertJsonStructure([
            'success',
            'message',
            'data' => [
                'id',
                'college_id',
                'reviewer_name',
                'rating',
                'status',
            ],
        ])
        ->assertJson([
            'success' => true,
            'data' => [
                'college_id' => $college->id,
                'reviewer_name' => 'Sneha Roy',
                'rating' => 4,
                'status' => 'pending',
            ],
        ]);
});

test('honeypot bot submission is blocked', function () {
    $college = makeCollegeForSubmission();

    $response = $this->post(route('college.reviews.store', $college->slug), [
        'reviewer_name' => 'Bot Spammer',
        'email' => 'spambot@example.com',
        'rating' => 5,
        'review' => 'Buy cheap pharmaceutical pills online here right now!',
        'website_hp' => 'http://spambot-attack.ru',
    ]);

    $response->assertSessionHasErrors('website_hp');
    $this->assertDatabaseMissing('college_reviews', [
        'reviewer_name' => 'Bot Spammer',
    ]);
});

test('validation fails for missing or invalid inputs', function () {
    $college = makeCollegeForSubmission();

    // 1. Missing name & invalid email & rating out of bounds
    $response = $this->post(route('college.reviews.store', $college->slug), [
        'reviewer_name' => '',
        'email' => 'not-an-email',
        'rating' => 6,
        'review' => 'Too short',
    ]);

    $response->assertSessionHasErrors(['reviewer_name', 'email', 'rating', 'review']);

    // 2. Rating 0
    $responseZeroRating = $this->post(route('college.reviews.store', $college->slug), [
        'reviewer_name' => 'Test User',
        'email' => 'user@example.com',
        'rating' => 0,
        'review' => 'This is a long enough review text for the test.',
    ]);

    $responseZeroRating->assertSessionHasErrors(['rating']);
});

test('html tags are stripped to sanitize reviews against xss', function () {
    $college = makeCollegeForSubmission();

    $response = $this->post(route('college.reviews.store', $college->slug), [
        'reviewer_name' => '<b>Ankit Sharma</b>',
        'email' => 'ankit@example.com',
        'course' => '<i>BCA Cloud</i>',
        'rating' => 5,
        'review' => '<p>Great college with <a href="http://malicious.com">amazing</a> laboratories and campus culture.</p>',
    ]);

    $response->assertSessionHas('review_success');

    $review = CollegeReview::where('college_id', $college->id)->first();
    expect($review->reviewer_name)->toBe('Ankit Sharma')
        ->and($review->reviewer_name)->not->toContain('<b>')
        ->and($review->course)->toBe('BCA Cloud')
        ->and($review->course)->not->toContain('<i>')
        ->and($review->review)->not->toContain('<p>')
        ->and($review->review)->not->toContain('<a href')
        ->and($review->review)->toContain('Great college with amazing laboratories');
});

test('rate limiting throttles excessive submissions from same ip', function () {
    $college = makeCollegeForSubmission();

    // The route has throttle:5,60. Send 5 requests successfully:
    for ($i = 1; $i <= 5; $i++) {
        $response = $this->post(route('college.reviews.store', $college->slug), [
            'reviewer_name' => "Student {$i}",
            'email' => "student{$i}@example.com",
            'rating' => 5,
            'review' => 'Valid and genuine student feedback message number '.$i,
        ]);

        $response->assertSessionHas('review_success');
    }

    // 6th request from the same client should be throttled (HTTP 429)
    $responseThrottled = $this->post(route('college.reviews.store', $college->slug), [
        'reviewer_name' => 'Student 6',
        'email' => 'student6@example.com',
        'rating' => 5,
        'review' => 'Another valid and genuine feedback message number 6',
    ]);

    $responseThrottled->assertStatus(429);
});
