<?php

use App\Models\College;
use App\Models\CollegeReview;
use App\Models\User;

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

test('guest and non-admin student users cannot access admin review moderation suite', function () {
    $college = makeModerationCollege();
    $review = CollegeReview::create([
        'college_id' => $college->id,
        'reviewer_name' => 'Anonymous Guest',
        'email' => 'guest@example.com',
        'rating' => 4,
        'review' => 'Great campus facilities and faculty.',
        'status' => 'pending',
    ]);

    // 1. Unauthenticated Guest
    $this->get(route('admin.reviews.index'))
        ->assertRedirect(route('login'));

    $this->post(route('admin.reviews.approve', $review))
        ->assertRedirect(route('login'));

    $this->post(route('admin.reviews.reject', $review))
        ->assertRedirect(route('login'));

    $this->delete(route('admin.reviews.destroy', $review))
        ->assertRedirect(route('login'));

    // 2. Student Role User
    $student = User::factory()->create(['role' => 'student']);

    $this->actingAs($student)->get(route('admin.reviews.index'))
        ->assertRedirect(route('login'))
        ->assertSessionHas('error', 'Unauthorized access.');

    $this->actingAs($student)->post(route('admin.reviews.approve', $review))
        ->assertRedirect(route('login'))
        ->assertSessionHas('error', 'Unauthorized access.');
});

test('admin can access reviews index and view review counters and pending reviews by default', function () {
    $admin = User::factory()->create(['role' => 'super_admin']);
    $college = makeModerationCollege();

    CollegeReview::create([
        'college_id' => $college->id,
        'reviewer_name' => 'Pending Reviewer',
        'email' => 'pending@example.com',
        'course' => 'B.Tech IT',
        'rating' => 5,
        'review' => 'Pending review waiting for approval.',
        'status' => 'pending',
    ]);

    CollegeReview::create([
        'college_id' => $college->id,
        'reviewer_name' => 'Approved Reviewer',
        'email' => 'approved@example.com',
        'course' => 'MBA',
        'rating' => 4,
        'review' => 'Approved and live on the public site.',
        'status' => 'approved',
    ]);

    CollegeReview::create([
        'college_id' => $college->id,
        'reviewer_name' => 'Rejected Reviewer',
        'email' => 'rejected@example.com',
        'rating' => 1,
        'review' => 'Spam content that was rejected.',
        'status' => 'rejected',
    ]);

    $response = $this->actingAs($admin)->get(route('admin.reviews.index'));

    $response->assertStatus(200);
    $response->assertSee('College Reviews Moderation');
    $response->assertSee('Pending Reviewer');
    // Approved & Rejected should not be in the default 'pending' tab list
    $response->assertDontSee('Approved Reviewer');
    $response->assertDontSee('Rejected Reviewer');

    // Counts should be passed to the view
    $response->assertViewHas('pendingCount', 1);
    $response->assertViewHas('approvedCount', 1);
    $response->assertViewHas('rejectedCount', 1);
    $response->assertViewHas('allCount', 3);
});

test('admin can filter reviews by status tab', function () {
    $admin = User::factory()->create(['role' => 'super_admin']);
    $college = makeModerationCollege();

    CollegeReview::create([
        'college_id' => $college->id,
        'reviewer_name' => 'Student Alfa',
        'email' => 'alfa@example.com',
        'rating' => 5,
        'review' => 'Alpha pending review text.',
        'status' => 'pending',
    ]);

    CollegeReview::create([
        'college_id' => $college->id,
        'reviewer_name' => 'Student Beta',
        'email' => 'beta@example.com',
        'rating' => 4,
        'review' => 'Beta approved review text.',
        'status' => 'approved',
    ]);

    CollegeReview::create([
        'college_id' => $college->id,
        'reviewer_name' => 'Student Gamma',
        'email' => 'gamma@example.com',
        'rating' => 2,
        'review' => 'Gamma rejected review text.',
        'status' => 'rejected',
    ]);

    // Check Approved tab
    $approvedResponse = $this->actingAs($admin)->get(route('admin.reviews.index', ['status' => 'approved']));
    $approvedResponse->assertStatus(200);
    $approvedResponse->assertSee('Student Beta');
    $approvedResponse->assertDontSee('Student Alfa');
    $approvedResponse->assertDontSee('Student Gamma');

    // Check Rejected tab
    $rejectedResponse = $this->actingAs($admin)->get(route('admin.reviews.index', ['status' => 'rejected']));
    $rejectedResponse->assertStatus(200);
    $rejectedResponse->assertSee('Student Gamma');
    $rejectedResponse->assertDontSee('Student Alfa');
    $rejectedResponse->assertDontSee('Student Beta');

    // Check All tab
    $allResponse = $this->actingAs($admin)->get(route('admin.reviews.index', ['status' => 'all']));
    $allResponse->assertStatus(200);
    $allResponse->assertSee('Student Alfa');
    $allResponse->assertSee('Student Beta');
    $allResponse->assertSee('Student Gamma');
});

test('admin can search reviews by keyword across name, email, course, review text, and college', function () {
    $admin = User::factory()->create(['role' => 'super_admin']);
    $college = makeModerationCollege(['name' => 'Zenith University']);

    CollegeReview::create([
        'college_id' => $college->id,
        'reviewer_name' => 'UniqueNameXYZ',
        'email' => 'xyz@zenith.edu',
        'course' => 'Biomedical Science',
        'rating' => 5,
        'review' => 'Groundbreaking laboratory facilities.',
        'status' => 'pending',
    ]);

    CollegeReview::create([
        'college_id' => $college->id,
        'reviewer_name' => 'Regular Person',
        'email' => 'person@regular.com',
        'course' => 'Civil Engineering',
        'rating' => 3,
        'review' => 'Average campus infrastructure.',
        'status' => 'pending',
    ]);

    // Search by reviewer name
    $searchResponse = $this->actingAs($admin)->get(route('admin.reviews.index', ['status' => 'all', 'search' => 'UniqueNameXYZ']));
    $searchResponse->assertStatus(200);
    $searchResponse->assertSee('UniqueNameXYZ');
    $searchResponse->assertDontSee('Regular Person');

    // Search by course
    $courseResponse = $this->actingAs($admin)->get(route('admin.reviews.index', ['status' => 'all', 'search' => 'Biomedical']));
    $courseResponse->assertStatus(200);
    $courseResponse->assertSee('UniqueNameXYZ');
    $courseResponse->assertDontSee('Regular Person');
});

test('admin can filter reviews by college id', function () {
    $admin = User::factory()->create(['role' => 'super_admin']);
    $collegeA = makeModerationCollege(['name' => 'College Alpha']);
    $collegeB = makeModerationCollege(['name' => 'College Beta']);

    CollegeReview::create([
        'college_id' => $collegeA->id,
        'reviewer_name' => 'Alpha Reviewer',
        'email' => 'alpha@test.com',
        'rating' => 5,
        'review' => 'Great experience at College Alpha.',
        'status' => 'pending',
    ]);

    CollegeReview::create([
        'college_id' => $collegeB->id,
        'reviewer_name' => 'Beta Reviewer',
        'email' => 'beta@test.com',
        'rating' => 4,
        'review' => 'Great experience at College Beta.',
        'status' => 'pending',
    ]);

    $response = $this->actingAs($admin)->get(route('admin.reviews.index', [
        'status' => 'all',
        'college_id' => $collegeA->id,
    ]));

    $response->assertStatus(200);
    $response->assertSee('Alpha Reviewer');
    $response->assertDontSee('Beta Reviewer');
});

test('admin can approve a pending review and make it immediately visible on the public college page', function () {
    $admin = User::factory()->create(['role' => 'super_admin']);
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
    $response = $this->actingAs($admin)->post(route('admin.reviews.approve', $review));
    $response->assertRedirect();
    $response->assertSessionHas('success');

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

test('admin can reject an approved review and remove it from the public college page', function () {
    $admin = User::factory()->create(['role' => 'super_admin']);
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
    $response = $this->actingAs($admin)->post(route('admin.reviews.reject', $review));
    $response->assertRedirect();
    $response->assertSessionHas('success');

    // Database assertion
    $this->assertDatabaseHas('college_reviews', [
        'id' => $review->id,
        'status' => 'rejected',
    ]);

    // Verify it is no longer visible on public college page
    $this->get(route('college.show', $college->slug))
        ->assertDontSee('Sneha Kapoor');
});

test('admin can permanently delete a review', function () {
    $admin = User::factory()->create(['role' => 'super_admin']);
    $college = makeModerationCollege();

    $review = CollegeReview::create([
        'college_id' => $college->id,
        'reviewer_name' => 'To Be Deleted',
        'email' => 'spam@example.com',
        'rating' => 1,
        'review' => 'Malicious or inappropriate spam comment.',
        'status' => 'rejected',
    ]);

    $response = $this->actingAs($admin)->delete(route('admin.reviews.destroy', $review));
    $response->assertRedirect();
    $response->assertSessionHas('success');

    $this->assertDatabaseMissing('college_reviews', [
        'id' => $review->id,
    ]);
});
