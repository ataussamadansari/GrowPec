<?php

use App\Models\WebsiteReview;

test('guest can submit valid website review and receives success message', function () {
    $response = $this->post(route('website.reviews.store'), [
        'reviewer_name' => 'Rohan Sharma',
        'email' => 'Rohan@Example.com',
        'title' => 'Great Career Counseling',
        'rating' => 5,
        'review' => 'The GrowPec portal made comparing universities so easy and transparent.',
    ]);

    $response->assertSessionHas('website_review_success');
    $response->assertRedirect();

    $this->assertDatabaseHas('website_reviews', [
        'reviewer_name' => 'Rohan Sharma',
        'email' => 'rohan@example.com',
        'title' => 'Great Career Counseling',
        'rating' => 5,
        'status' => 'pending',
    ]);

    $review = WebsiteReview::where('email', 'rohan@example.com')->first();
    expect($review->isPending())->toBeTrue()
        ->and($review->ip_address)->not->toBeNull();
});

test('guest can submit review via JSON API and receives 201 response with safe data', function () {
    $response = $this->postJson(route('website.reviews.store'), [
        'reviewer_name' => 'Pooja Iyer',
        'email' => 'pooja@example.com',
        'rating' => 4,
        'review' => 'Prompt counseling support and accurate fee breakdowns across colleges.',
    ]);

    $response->assertStatus(201)
        ->assertJsonStructure([
            'success',
            'message',
            'data' => [
                'id',
                'reviewer_name',
                'rating',
                'status',
            ],
        ])
        ->assertJson([
            'success' => true,
            'data' => [
                'reviewer_name' => 'Pooja Iyer',
                'rating' => 4,
                'status' => 'pending',
            ],
        ]);

    // Ensure email is NEVER leaked in JSON response
    $json = $response->json();
    expect(isset($json['data']['email']))->toBeFalse()
        ->and(isset($json['data']['ip_address']))->toBeFalse();
});

test('honeypot bot submission to website reviews is blocked', function () {
    $response = $this->post(route('website.reviews.store'), [
        'reviewer_name' => 'Bot Spammer',
        'email' => 'bot@spammer.org',
        'rating' => 5,
        'review' => 'Visit my promotional spam website for free loans and discounts!',
        'website_hp' => 'http://spam-link.xyz',
    ]);

    $response->assertSessionHasErrors('website_hp');
    $this->assertDatabaseMissing('website_reviews', [
        'reviewer_name' => 'Bot Spammer',
    ]);
});

test('validation fails for invalid inputs on website review submission', function () {
    // 1. Missing required fields
    $response = $this->post(route('website.reviews.store'), [
        'reviewer_name' => '',
        'email' => 'not-an-email',
        'rating' => 6,
        'review' => 'Too short',
    ]);

    $response->assertSessionHasErrors(['reviewer_name', 'email', 'rating', 'review']);
});

test('homepage only calculates average rating from approved website reviews', function () {
    WebsiteReview::create([
        'reviewer_name' => 'Approved Five Star',
        'email' => 'user1@example.com',
        'rating' => 5,
        'review' => 'Exceptional platform experience with reliable counselor guidance.',
        'status' => 'approved',
    ]);

    WebsiteReview::create([
        'reviewer_name' => 'Approved Four Star',
        'email' => 'user2@example.com',
        'rating' => 4,
        'review' => 'Really helpful comparisons for online MBA programs in India.',
        'status' => 'approved',
    ]);

    // Pending and rejected reviews must NOT count
    WebsiteReview::create([
        'reviewer_name' => 'Pending Review',
        'email' => 'pending@example.com',
        'rating' => 1,
        'review' => 'Pending review that must not affect the public average score.',
        'status' => 'pending',
    ]);

    WebsiteReview::create([
        'reviewer_name' => 'Rejected Review',
        'email' => 'rejected@example.com',
        'rating' => 1,
        'review' => 'Rejected review that must not affect the public average score.',
        'status' => 'rejected',
    ]);

    $approvedReviews = WebsiteReview::approved();
    $avgRating = round((float) $approvedReviews->avg('rating'), 1);
    $approvedCount = $approvedReviews->count();

    expect($avgRating)->toBe(4.5)
        ->and($approvedCount)->toBe(2);

    $response = $this->get(route('home'));
    $response->assertOk()
        ->assertSee('Approved Five Star')
        ->assertSee('Approved Four Star')
        ->assertDontSee('Pending Review')
        ->assertDontSee('Rejected Review');
});

test('direct review link redirects to home with write_review parameter and anchor', function () {
    $response = $this->get(route('website.reviews.write'));

    $response->assertRedirect(route('home', ['write_review' => 1]).'#growpecReviewsSection');
});

test('direct review link with rating parameter passes rating in redirect', function () {
    $response = $this->get(route('website.reviews.write', ['rating' => 5]));

    $response->assertRedirect(route('home', ['write_review' => 1, 'rating' => 5]).'#growpecReviewsSection');
});

test('rate-us route redirects to home with write_review parameter', function () {
    $response = $this->get(route('website.reviews.rate'));

    $response->assertRedirect(route('home', ['write_review' => 1]).'#growpecReviewsSection');
});

test('reviews index route redirects to home reviews section', function () {
    $response = $this->get(route('website.reviews.index'));

    $response->assertRedirect(route('home').'#growpecReviewsSection');

    $withWrite = $this->get(route('website.reviews.index', ['write' => 1]));
    $withWrite->assertRedirect(route('home', ['write_review' => 1]).'#growpecReviewsSection');
});

test('homepage renders auto-open review modal and direct link triggers', function () {
    $response = $this->get(route('home', ['write_review' => 1]));

    $response->assertOk()
        ->assertSee('id="websiteReviewModal"', false)
        ->assertSee('handleDirectOpenReviewModal', false)
        ->assertSee('copyGrowPecReviewLink', false)
        ->assertSee('Share direct link');
});
