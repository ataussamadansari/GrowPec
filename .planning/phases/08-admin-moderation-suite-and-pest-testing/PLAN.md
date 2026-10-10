# Phase 8 Plan: Admin Moderation Suite & Pest Testing

**Phase:** 8  
**Milestone:** v1.1 — Public Guest College Review System (Without Login)  
**Goal:** Build a complete administrative moderation interface to approve, reject, or delete visitor reviews, integrate the admin sidebar link with badge counters, and author comprehensive automated feature tests.  
**Status:** Ready to Execute  

---

## 1. Context & Architecture

Existing state:
- Schema and models (Phase 5), public controller and rate limiting (Phase 6), and frontend detail page showcase/form (Phase 7) are completed and verified.
- Reviews submitted by public guests are stored with `status = 'pending'`.
- There is currently no admin controller or view to manage reviews.

Planned state:
- Controller: `App\Http\Controllers\Admin\ReviewManagerController` with `index`, `approve`, `reject`, and `destroy` methods.
- Routes: `admin.reviews.*` registered in `routes/web.php` under the existing authenticated admin group.
- View: `resources/views/admin/reviews/index.blade.php` with status tabs, search/filter controls, review table, and quick moderation actions.
- Layout: Add "College Reviews" navigation item with pending count badge in `resources/views/admin/layout.blade.php`.
- Test Suite: `tests/Feature/CollegeReviewModerationTest.php` verifying authorization, status changes, deletions, and public visibility sync.

---

## 2. Tasks & Execution Steps

### Task 8.1: Create `ReviewManagerController`
- **Artifact:** `app/Http/Controllers/Admin/ReviewManagerController.php`
- **Actions:**
  1. Generate controller using `php artisan make:controller Admin/ReviewManagerController --no-interaction`.
  2. Implement `index(Request $request): View`:
     - Filter by status (`all`, `pending`, `approved`, `rejected`, defaulting to `pending` or request parameter).
     - Search by reviewer name, email, review text, or college name.
     - Filter by college ID.
     - Compute counts for all tabs (`pendingCount`, `approvedCount`, `rejectedCount`, `allCount`).
     - Eager load `college` relation and paginate 15 per page.
  3. Implement `approve(CollegeReview $review): RedirectResponse`:
     - Update `$review->update(['status' => 'approved'])`.
     - Return back with `success` flash: *"Review approved and published to college profile."*
  4. Implement `reject(CollegeReview $review): RedirectResponse`:
     - Update `$review->update(['status' => 'rejected'])`.
     - Return back with `success` flash: *"Review marked as rejected."*
  5. Implement `destroy(CollegeReview $review): RedirectResponse`:
     - Delete record `$review->delete()`.
     - Return back with `success` flash: *"Review deleted permanently."*

### Task 8.2: Register Admin Routes in `routes/web.php`
- **Artifact:** [routes/web.php](file:///d:/GrowPec/GrowPec/routes/web.php)
- **Actions:**
  1. Import `App\Http\Controllers\Admin\ReviewManagerController as AdminReview`.
  2. Under `admin.` prefix group, register:
     ```php
     Route::get('/reviews', [AdminReview::class, 'index'])->name('reviews.index');
     Route::post('/reviews/{review}/approve', [AdminReview::class, 'approve'])->name('reviews.approve');
     Route::post('/reviews/{review}/reject', [AdminReview::class, 'reject'])->name('reviews.reject');
     Route::delete('/reviews/{review}', [AdminReview::class, 'destroy'])->name('reviews.destroy');
     ```

### Task 8.3: Create Admin Moderation View
- **Artifact:** `resources/views/admin/reviews/index.blade.php`
- **Actions:**
  1. Create directory `resources/views/admin/reviews/` if not present.
  2. Build moderation dashboard extending `admin.layout`:
     - Breadcrumb & Page header ("College Reviews Moderation").
     - Status tabs (Pending with badge, Approved with badge, Rejected with badge, All).
     - Search & Filter bar (keyword search, college filter dropdown, status select).
     - Table columns: Reviewer (Name, Email, IP Address), College, Rating (stars + score), Course, Review body excerpt, Status badge, Submitted date, Actions.
     - Actions toolbar:
       - Approve button (form POST to `admin.reviews.approve`).
       - Reject button (form POST to `admin.reviews.reject`).
       - Delete button (form DELETE to `admin.reviews.destroy` with confirm prompt).
     - Empty state when no reviews match criteria.
     - Pagination links.

### Task 8.4: Update Admin Sidebar in `admin/layout.blade.php`
- **Artifact:** [resources/views/admin/layout.blade.php](file:///d:/GrowPec/GrowPec/resources/views/admin/layout.blade.php)
- **Actions:**
  1. In the "Management" nav section, add a link to `admin.reviews.index` with star icon (`bi-star-half`).
  2. Query pending review count and display a pill badge when count > 0.

### Task 8.5: Author Pest Automated Moderation Tests
- **Artifact:** `tests/Feature/CollegeReviewModerationTest.php`
- **Actions:**
  1. Generate test with `php artisan make:test --pest CollegeReviewModerationTest --no-interaction`.
  2. Test cases:
     - Guests and non-admin users cannot access `admin.reviews.index` or action routes.
     - Admin can access `admin.reviews.index` and see reviews list.
     - Admin can filter reviews by status (`status=pending`, `status=approved`, `status=rejected`).
     - Admin can search reviews by keyword.
     - Admin can approve a pending review; review status updates to `'approved'` and becomes visible on public college detail page.
     - Admin can reject an approved review; review status updates to `'rejected'` and disappears from public college detail page.
     - Admin can delete a review permanently.
  3. Execute tests: `php artisan test --filter=CollegeReviewModerationTest`.
  4. Run Pint code formatter: `vendor/bin/pint --dirty --format agent`.

---

## 3. Verification & Acceptance Criteria
- [ ] Admin can view reviews index at `/admin/reviews`.
- [ ] Status tabs display correct real-time counters.
- [ ] Approving a review publishes it to the public page immediately.
- [ ] Rejecting a review removes it from the public page immediately.
- [ ] Deleting a review removes the record from the database.
- [ ] Sidebar displays "College Reviews" link and pending count pill.
- [ ] All Pest tests in `CollegeReviewModerationTest` pass (100% green).
- [ ] Entire test suite passes without regressions.
- [ ] Clean Pint formatting.
