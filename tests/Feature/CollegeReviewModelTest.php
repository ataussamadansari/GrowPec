<?php

use App\Models\College;
use App\Models\CollegeReview;

function createTestCollege(array $attributes = []): College
{
    return College::create(array_merge([
        'name' => 'Apex Institute of Technology',
        'slug' => 'apex-institute-of-technology-'.uniqid(),
        'college_mode' => 'regular',
        'state' => 'Delhi',
        'city' => 'New Delhi',
        'status' => true,
        'rating' => 4.0,
    ], $attributes));
}

test('guest can create review with default pending status', function () {
    $college = createTestCollege();

    $review = CollegeReview::create([
        'college_id' => $college->id,
        'reviewer_name' => 'Rahul Sharma',
        'email' => 'rahul@example.com',
        'course' => 'B.Tech Computer Science',
        'rating' => 5,
        'review' => 'Excellent campus infrastructure, supportive faculty, and great placement record.',
        'ip_address' => '127.0.0.1',
    ]);

    expect($review->id)->not->toBeNull()
        ->and($review->user_id)->toBeNull()
        ->and($review->reviewer_name)->toBe('Rahul Sharma')
        ->and($review->email)->toBe('rahul@example.com')
        ->and($review->status)->toBe('pending')
        ->and($review->isPending())->toBeTrue()
        ->and($review->isApproved())->toBeFalse()
        ->and($review->isRejected())->toBeFalse();

    $this->assertDatabaseHas('college_reviews', [
        'id' => $review->id,
        'college_id' => $college->id,
        'reviewer_name' => 'Rahul Sharma',
        'email' => 'rahul@example.com',
        'status' => 'pending',
    ]);
});

test('aliases course_enrolled and review_text work seamlessly', function () {
    $college = createTestCollege();

    $review = new CollegeReview;
    $review->college_id = $college->id;
    $review->reviewer_name = 'Priya Patel';
    $review->email = 'priya@example.com';
    $review->course_enrolled = 'MBA Marketing';
    $review->rating = 4;
    $review->review_text = 'Great curriculum and corporate interaction opportunities.';
    $review->save();

    expect($review->course)->toBe('MBA Marketing')
        ->and($review->course_enrolled)->toBe('MBA Marketing')
        ->and($review->review)->toBe('Great curriculum and corporate interaction opportunities.')
        ->and($review->review_text)->toBe('Great curriculum and corporate interaction opportunities.');
});

test('scopes filter reviews by status correctly', function () {
    $college = createTestCollege();

    $pending = CollegeReview::create([
        'college_id' => $college->id,
        'reviewer_name' => 'Student 1',
        'email' => 's1@example.com',
        'rating' => 4,
        'review' => 'Pending feedback content here.',
        'status' => 'pending',
    ]);

    $approved = CollegeReview::create([
        'college_id' => $college->id,
        'reviewer_name' => 'Student 2',
        'email' => 's2@example.com',
        'rating' => 5,
        'review' => 'Approved feedback content here.',
        'status' => 'approved',
    ]);

    $rejected = CollegeReview::create([
        'college_id' => $college->id,
        'reviewer_name' => 'Student 3',
        'email' => 's3@example.com',
        'rating' => 1,
        'review' => 'Spam or abusive content here.',
        'status' => 'rejected',
    ]);

    expect(CollegeReview::pending()->pluck('id')->all())->toContain($pending->id)
        ->and(CollegeReview::pending()->pluck('id')->all())->not->toContain($approved->id)
        ->and(CollegeReview::approved()->pluck('id')->all())->toContain($approved->id)
        ->and(CollegeReview::approved()->pluck('id')->all())->not->toContain($pending->id)
        ->and(CollegeReview::rejected()->pluck('id')->all())->toContain($rejected->id);
});

test('college model relationships and average rating work dynamically', function () {
    $college = createTestCollege(['rating' => 3.5]);

    // Initial state: no reviews, should fallback to college rating
    expect($college->approved_reviews_count)->toBe(0)
        ->and($college->average_rating)->toBe(3.5);

    // Add a pending review: should not affect average or approved count
    CollegeReview::create([
        'college_id' => $college->id,
        'reviewer_name' => 'Pending Student',
        'email' => 'pending@example.com',
        'rating' => 1,
        'review' => 'Pending negative review.',
        'status' => 'pending',
    ]);

    $college->refresh();
    expect($college->reviews()->count())->toBe(1)
        ->and($college->approved_reviews_count)->toBe(0)
        ->and($college->average_rating)->toBe(3.5);

    // Add two approved reviews: ratings 4 and 5 (average 4.5)
    CollegeReview::create([
        'college_id' => $college->id,
        'reviewer_name' => 'Approved Student 1',
        'email' => 'app1@example.com',
        'rating' => 4,
        'review' => 'Very good experience.',
        'status' => 'approved',
    ]);

    CollegeReview::create([
        'college_id' => $college->id,
        'reviewer_name' => 'Approved Student 2',
        'email' => 'app2@example.com',
        'rating' => 5,
        'review' => 'Top notch faculties.',
        'status' => 'approved',
    ]);

    $college->refresh();
    expect($college->approved_reviews_count)->toBe(2)
        ->and($college->approvedReviews()->count())->toBe(2)
        ->and($college->average_rating)->toBe(4.5);
});
