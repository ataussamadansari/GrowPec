# Phase 7 Plan: Public Frontend UI (Detail Page Integration)

**Phase:** 7  
**Milestone:** v1.1 — Public Guest College Review System (Without Login)  
**Goal:** Integrate a polished student reviews section and interactive "Write a Review" form into the public college detail page (`/college/{slug}`).  
**Status:** Ready to Execute  

---

## 1. Context & Architecture

Existing state:
- Schema, models, controller, validation, and route (`POST /college/{slug}/reviews`) are completed and tested.
- `app/Http/Controllers/CollegeController@show` eager-loads college relations and builds dynamic `$quickNav`.
- [resources/views/colleges/show.blade.php](file:///d:/GrowPec/GrowPec/resources/views/colleges/show.blade.php) contains left sticky navigation and sequential content blocks (`sec-overview`, `sec-quickfacts`, ..., `sec-faqs`), but does not have a Reviews block.

Planned state:
- Update `CollegeController@show` to eager load `'approvedReviews'` and include `'sec-reviews'` in `$quickNav`.
- Add a new block `<div class="c-block" id="sec-reviews">` in `resources/views/colleges/show.blade.php`:
  1. Header with "Student Reviews & Ratings" and "Write a Review" toggle CTA.
  2. Aggregate rating summary card (overall score, gold stars, total count, rating distribution bars).
  3. Feed of approved reviews (reviewer initials avatar, name, verified badge, course, star rating, submission date, review body).
  4. Friendly empty state when 0 reviews exist.
  5. Interactive "Write a Review" form card with 5-star rating hover/click selector, name, email, course, review textarea, invisible honeypot field (`website_hp`), moderation notice, and submission button.
  6. Flash success message banner when `session('review_success')` is present.
- Feature tests in `tests/Feature/CollegeReviewViewTest.php`.

---

## 2. Tasks & Execution Steps

### Task 7.1: Update `CollegeController@show`
- **Artifact:** [app/Http/Controllers/CollegeController.php](file:///d:/GrowPec/GrowPec/app/Http/Controllers/CollegeController.php)
- **Actions:**
  1. In `show` query eager loading, include `'approvedReviews'`.
  2. In `$quickNav` list, add:
     ```php
     $quickNav[] = ['id' => 'sec-reviews', 'title' => 'Student Reviews', 'icon' => 'bi-star-half'];
     ```

### Task 7.2: Add Reviews Section Styles in `show.blade.php`
- **Artifact:** [resources/views/colleges/show.blade.php](file:///d:/GrowPec/GrowPec/resources/views/colleges/show.blade.php)
- **Actions:**
  1. Add CSS rules in `@push('styles')`:
     - `.c-reviews-summary`: Summary card layout (flex/grid with gold score badge and progress bars).
     - `.c-review-card`: Review item card with left avatar circle, reviewer meta, and review text.
     - `.c-star-rating`: Interactive 5-star rating component with gold fill on hover/checked state.
     - `.c-honeypot`: Invisible field hidden with `display:none!important;visibility:hidden;`.

### Task 7.3: Implement Reviews Markup in `show.blade.php`
- **Artifact:** [resources/views/colleges/show.blade.php](file:///d:/GrowPec/GrowPec/resources/views/colleges/show.blade.php)
- **Actions:**
  1. Insert `<div class="c-block" id="sec-reviews">` following the FAQs block.
  2. Display flash message `@if(session('review_success'))` with checkmark icon and auto-scroll target.
  3. Render overall rating card and distribution bars.
  4. Render list of `@foreach($college->approvedReviews as $r)` cards.
  5. If count is 0, render empty state: *"Be the first student to review this institution!"*.
  6. Render `#writeReviewCard`:
     - Form `POST` to `route('college.reviews.store', $college->slug)`.
     - CSRF token `@csrf`.
     - Honeypot input `<input type="text" name="website_hp" class="c-honeypot" tabindex="-1" autocomplete="off">`.
     - 5-Star interactive radio group (`name="rating"`).
     - Name input (`name="reviewer_name"`).
     - Email input (`name="email"`).
     - Course input (`name="course"`).
     - Textarea (`name="review"`).
     - Submit button and moderation disclaimer.

### Task 7.4: Add Interactive Star Rating JavaScript
- **Artifact:** [resources/views/colleges/show.blade.php](file:///d:/GrowPec/GrowPec/resources/views/colleges/show.blade.php)
- **Actions:**
  1. Add client-side script for the star rating widget:
     - Highlight stars on hover.
     - Persist selected star on click and update label text (e.g. "5 Stars - Excellent").
     - Prevent double submission on form submit.

### Task 7.5: Author Pest View Integration Tests
- **Artifact:** `tests/Feature/CollegeReviewViewTest.php`
- **Actions:**
  1. Create test file with `php artisan make:test --pest CollegeReviewViewTest --no-interaction`.
  2. Test cases:
     - Public college detail page renders the Reviews section (`#sec-reviews`).
     - Approved reviews are visible on the page with reviewer name and content.
     - Pending reviews are NOT displayed on the public page.
     - Rejected reviews are NOT displayed on the public page.
     - Empty state renders when a college has zero approved reviews.
     - The review submission form is present with CSRF, honeypot, and required input fields.
     - Session flash message `review_success` renders when redirected after submission.
  3. Run tests with `php artisan test --filter=CollegeReviewViewTest`.
  4. Format with `vendor/bin/pint --dirty --format agent`.

---

## 3. Verification & Acceptance Criteria
- [ ] Section `#sec-reviews` appears on `/college/{slug}` and is linked in sticky navigation.
- [ ] Approved reviews render with stars, author names, and verified badges.
- [ ] Pending/rejected reviews are never exposed to public visitors.
- [ ] Star rating selector is interactive with instant visual feedback.
- [ ] Submitting the form redirects back with success confirmation.
- [ ] All Pest tests in `CollegeReviewViewTest` pass (100% green).
- [ ] Entire test suite passes without regressions.
- [ ] Clean Pint formatting.
