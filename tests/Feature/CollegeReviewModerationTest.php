<?php

use App\Models\College;
use App\Models\CollegeReview;

function makeModerationCollege(array $attributes = []): College
{
    return College::create(array_merge([
        'name' => 'Apex Engineering College',
        'slug' => 'apex-engineering-college-'.uniqid(),
        'college_mode' => 'regular',
        'state' => 'Karnataka',
        'city' => 'Bengaluru',
        'status' => true,
        'rating' => 4.5,
    ], $attributes));
}

test('college review defaults to pending status with correct helper checks', function () {
    $college = makeModerationCollege();
    $review = CollegeReview::create([
        'college_id' => $college->id,
        'reviewer_name' => 'Anonymous Guest',
        'email' => 'guest@example.com',
        'rating' => 4,
        'review' => 'Great campus facilities and faculty.',
    ]);

    expect($review->status)->toBe('pending')
        ->and($review->isPending())->toBeTrue()
        ->and($review->isApproved())->toBeFalse()
        ->and($review->isRejected())->toBeFalse();
});

test('college review status scopes filter records accurately', function () {
    $college = makeModerationCollege();

    $pending = CollegeReview::create([
        'college_id' => $college->id,
        'reviewer_name' => 'Pending Reviewer',
        'email' => 'pending@example.com',
        'course' => 'B.Tech IT',
        'rating' => 5,
        'review' => 'Pending review waiting for approval.',
        'status' => 'pending',
    ]);

    $approved = CollegeReview::create([
        'college_id' => $college->id,
        'reviewer_name' => 'Approved Reviewer',
        'email' => 'approved@example.com',
        'course' => 'MBA',
        'rating' => 4,
        'review' => 'Approved and live on the public site.',
        'status' => 'approved',
    ]);

    $rejected = CollegeReview::create([
        'college_id' => $college->id,
        'reviewer_name' => 'Rejected Reviewer',
        'email' => 'rejected@example.com',
        'rating' => 1,
        'review' => 'Spam content that was rejected.',
        'status' => 'rejected',
    ]);

    $pendingIds = CollegeReview::pending()->pluck('id');
    $approvedIds = CollegeReview::approved()->pluck('id');
    $rejectedIds = CollegeReview::rejected()->pluck('id');

    expect($pendingIds)->toContain($pending->id)
        ->and($pendingIds)->not->toContain($approved->id)
        ->and($pendingIds)->not->toContain($rejected->id);

    expect($approvedIds)->toContain($approved->id)
        ->and($approvedIds)->not->toContain($pending->id)
        ->and($approvedIds)->not->toContain($rejected->id);

    expect($rejectedIds)->toContain($rejected->id)
        ->and($rejectedIds)->not->toContain($pending->id)
        ->and($rejectedIds)->not->toContain($approved->id);
});

test('college review transitions across status values with verification', function () {
    $college = makeModerationCollege();

    $review = CollegeReview::create([
        'college_id' => $college->id,
        'reviewer_name' => 'Transition Student',
        'email' => 'transition@example.com',
        'course' => 'MCA',
        'rating' => 5,
        'review' => 'Transitioning status check.',
        'status' => 'pending',
    ]);

    // Transition to approved
    $review->update(['status' => 'approved', 'is_verified' => true]);
    expect($review->fresh()->isApproved())->toBeTrue()
        ->and($review->fresh()->is_verified)->toBeTrue();

    // Transition to rejected
    $review->update(['status' => 'rejected']);
    expect($review->fresh()->isRejected())->toBeTrue()
        ->and($review->fresh()->isApproved())->toBeFalse();

    // Transition back to pending
    $review->update(['status' => 'pending']);
    expect($review->fresh()->isPending())->toBeTrue();
});

test('approving a review makes it immediately visible on public college page', function () {
    $college = makeModerationCollege(['name' => 'Pinnacle Institute of Technology']);

    $review = CollegeReview::create([
        'college_id' => $college->id,
        'reviewer_name' => 'Rohan Varma',
        'email' => 'rohan@example.com',
        'course' => 'B.Tech Robotics',
        'rating' => 5,
        'review' => 'Phenomenal robotics labs with modern robotic arms and simulation setups.',
        'status' => 'pending',
    ]);

    // Before approval: Not visible on public college page
    $publicBefore = $this->get(route('college.show', $college->slug));
    $publicBefore->assertDontSee('Rohan Varma');

    // Approve the review
    $review->update([
        'status' => 'approved',
        'is_verified' => true,
    ]);

    // Database assertions
    $this->assertDatabaseHas('college_reviews', [
        'id' => $review->id,
        'status' => 'approved',
        'is_verified' => true,
    ]);

    // After approval: Immediately visible on public college page
    $publicAfter = $this->get(route('college.show', $college->slug));
    $publicAfter->assertSee('Rohan Varma');
    $publicAfter->assertSee('Phenomenal robotics labs');
});

test('rejecting an approved review removes it from the public college page', function () {
    $college = makeModerationCollege(['name' => 'Sterling Commerce College']);

    $review = CollegeReview::create([
        'college_id' => $college->id,
        'reviewer_name' => 'Sneha Kapoor',
        'email' => 'sneha@example.com',
        'course' => 'B.Com Honours',
        'rating' => 4,
        'review' => 'Quality commerce faculty and lively campus events.',
        'status' => 'approved',
    ]);

    // Verify it is initially on the public page
    $this->get(route('college.show', $college->slug))
        ->assertSee('Sneha Kapoor');

    // Reject the review
    $review->update(['status' => 'rejected']);

    // Database assertion
    $this->assertDatabaseHas('college_reviews', [
        'id' => $review->id,
        'status' => 'rejected',
    ]);

    // Verify it is no longer visible on public college page
    $this->get(route('college.show', $college->slug))
        ->assertDontSee('Sneha Kapoor');
});

test('review can be permanently deleted', function () {
    $college = makeModerationCollege();

    $review = CollegeReview::create([
        'college_id' => $college->id,
        'reviewer_name' => 'To Be Deleted',
        'email' => 'spam@example.com',
        'rating' => 1,
        'review' => 'Malicious or inappropriate spam comment.',
        'status' => 'rejected',
    ]);

    $review->delete();

    $this->assertDatabaseMissing('college_reviews', [
        'id' => $review->id,
    ]);
});
