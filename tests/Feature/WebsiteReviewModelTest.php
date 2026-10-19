<?php

use App\Models\User;
use App\Models\WebsiteReview;

test('website review model has default pending status and correct casts', function () {
    $review = WebsiteReview::create([
        'reviewer_name' => 'Aditya Verma',
        'email' => 'aditya@example.com',
        'rating' => 5,
        'title' => 'Excellent Platform',
        'review' => 'GrowPec helped me discover the best accredited universities for online MCA.',
    ]);

    expect($review->status)->toBe('pending')
        ->and($review->isPending())->toBeTrue()
        ->and($review->isApproved())->toBeFalse()
        ->and($review->isRejected())->toBeFalse()
        ->and($review->rating)->toBe(5)
        ->and($review->is_featured)->toBeFalse();
});

test('website review scopes filter approved, pending, rejected, and featured records', function () {
    $pending = WebsiteReview::create([
        'reviewer_name' => 'Pending User',
        'email' => 'pending@example.com',
        'rating' => 4,
        'review' => 'Pending review waiting for approval from the moderation team.',
        'status' => 'pending',
    ]);

    $approved = WebsiteReview::create([
        'reviewer_name' => 'Approved User',
        'email' => 'approved@example.com',
        'rating' => 5,
        'review' => 'Approved review that should be visible on public homepage.',
        'status' => 'approved',
        'is_featured' => true,
    ]);

    $rejected = WebsiteReview::create([
        'reviewer_name' => 'Rejected User',
        'email' => 'rejected@example.com',
        'rating' => 1,
        'review' => 'Rejected spam submission that violated moderation policies.',
        'status' => 'rejected',
    ]);

    expect(WebsiteReview::pending()->pluck('id')->all())->toContain($pending->id)
        ->and(WebsiteReview::pending()->pluck('id')->all())->not->toContain($approved->id)
        ->and(WebsiteReview::approved()->pluck('id')->all())->toContain($approved->id)
        ->and(WebsiteReview::approved()->pluck('id')->all())->not->toContain($pending->id)
        ->and(WebsiteReview::rejected()->pluck('id')->all())->toContain($rejected->id)
        ->and(WebsiteReview::featured()->pluck('id')->all())->toContain($approved->id);
});

test('website review tracks moderator relationship', function () {
    $admin = User::create([
        'name' => 'Admin Moderator',
        'email' => 'moderator@growpec.com',
        'password' => bcrypt('secret123'),
        'role' => 'super_admin',
    ]);

    $review = WebsiteReview::create([
        'reviewer_name' => 'Kavita Singh',
        'email' => 'kavita@example.com',
        'rating' => 5,
        'review' => 'Very satisfied with the counseling team guidance and transparency.',
        'status' => 'approved',
        'moderated_by' => $admin->id,
        'moderated_at' => now(),
    ]);

    expect($review->moderatedBy)->not->toBeNull()
        ->and($review->moderatedBy->id)->toBe($admin->id)
        ->and($review->moderatedBy->name)->toBe('Admin Moderator');
});
