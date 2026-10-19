<?php

use App\Filament\Resources\WebsiteReviews\Pages\ListWebsiteReviews;
use App\Models\User;
use App\Models\WebsiteReview;
use Livewire\Livewire;

function makeAdminForWebsiteReview(): User
{
    return User::create([
        'name' => 'Review Moderator',
        'email' => 'mod-'.uniqid().'@growpec.com',
        'password' => bcrypt('password'),
        'role' => 'super_admin',
    ]);
}

test('admin can access website reviews list page in filament', function () {
    $admin = makeAdminForWebsiteReview();

    $this->actingAs($admin);

    Livewire::test(ListWebsiteReviews::class)
        ->assertSuccessful();
});

test('admin can approve pending website review', function () {
    $admin = makeAdminForWebsiteReview();
    $review = WebsiteReview::create([
        'reviewer_name' => 'Manish Gupta',
        'email' => 'manish@example.com',
        'rating' => 5,
        'review' => 'Great counseling support and clear college guidance from counselors.',
        'status' => 'pending',
    ]);

    $this->actingAs($admin);

    Livewire::test(ListWebsiteReviews::class)
        ->callTableAction('approve', $review);

    $review->refresh();
    expect($review->status)->toBe('approved')
        ->and($review->moderated_by)->toBe($admin->id)
        ->and($review->moderated_at)->not->toBeNull();
});

test('admin can reject website review with reason', function () {
    $admin = makeAdminForWebsiteReview();
    $review = WebsiteReview::create([
        'reviewer_name' => 'Inappropriate User',
        'email' => 'baduser@example.com',
        'rating' => 1,
        'review' => 'Spam content and abusive words promoting unrelated competitor services.',
        'status' => 'pending',
    ]);

    $this->actingAs($admin);

    Livewire::test(ListWebsiteReviews::class)
        ->callTableAction('reject', $review, data: [
            'moderation_reason' => 'Violates content policy and contains abusive language.',
        ]);

    $review->refresh();
    expect($review->status)->toBe('rejected')
        ->and($review->moderation_reason)->toBe('Violates content policy and contains abusive language.')
        ->and($review->moderated_by)->toBe($admin->id);
});

test('admin can unpublish approved website review back to pending', function () {
    $admin = makeAdminForWebsiteReview();
    $review = WebsiteReview::create([
        'reviewer_name' => 'Review To Unpublish',
        'email' => 'unpublish@example.com',
        'rating' => 4,
        'review' => 'This review was approved earlier but requires secondary verification.',
        'status' => 'approved',
    ]);

    $this->actingAs($admin);

    Livewire::test(ListWebsiteReviews::class)
        ->callTableAction('unpublish', $review);

    $review->refresh();
    expect($review->status)->toBe('pending');
});
